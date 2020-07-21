<?php

namespace App\Http\Controllers;

use App\{Guild, Item};
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'seeUser']);
    }

    /**
     * List the items
     *
     * @return \Illuminate\Http\Response
     */
    public function showWithGuild($guildSlug)
    {

    }

    /**
     * Show the mass input page
     *
     * @return \Illuminate\Http\Response
     */
    public function massInput($guildSlug)
    {
        $guild = Guild::where('slug', $guildSlug)->with([
            'characters',
            'members' => function ($query) {
                    return $query->where('members.user_id', Auth::id());
                },
            'raids',
            'raids.role'
            ])->firstOrFail();

        $currentMember = $guild->members->where('user_id', Auth::id())->first();

        // TODO: Keep this style of permissions check?
        if (!$currentMember) {
            abort(404, 'Not a member of that guild.');
        }

        // TODO: Validate user can view this guild's raids

        return view('item.massInput', [
            'currentMember' => $currentMember,
            'guild'         => $guild,
        ]);
    }

    /**
     * Show an item
     *
     * @return \Illuminate\Http\Response
     */
    public function showWithGuild($guildSlug, $id, $slug = null)
    {
        $guild = Guild::where('slug', $guildSlug)
            ->with(['members' => function ($query) {
                    return $query->where('members.id', Auth::id());
                        // Not grabbing member.user and member.user.roles here because the code is messier than just doing it in a separate call
                },
                'raids',
            ])
            ->firstOrFail();

        $item = Item::where('item_id', $id)->with([
            'receivedCharacters' => function ($query) use($guild) {
                return $query
                    ->where([
                        'characters.guild_id' => $guild->id,
                    ])
                    ->groupBy(['character_items.character_id'])
                    ->with([
                        'raid',
                        'received',
                        'recipes',
                        'wishlist',
                    ]);
            },
            'wishlistCharacters' => function ($query) use($guild) {
                return $query
                    ->where([
                        'characters.guild_id' => $guild->id,
                    ])
                    ->groupBy(['character_items.character_id'])
                    ->with([
                        'raid',
                        'received',
                        'recipes',
                        'wishlist',
                    ]);
            },
        ])->firstOrFail();

        // TODO: Permissions to view this guild's item entry..
        // I did a check here, not sure if it's what I'll use as a standard.
        // Leave it if it's fine, replace it if it's not.

        if (!$guild->members->first()) {
            abort(403, "You're not part of that guild.");
        }

        $itemSlug = slug($item->name);

        if ($slug && $slug != $itemSlug) {
            return redirect()->route('guild.item.show', ['guildSlug' => $guild->slug, 'item_id' => $item->item_id, 'slug' => slug($item->name)]);
        }

        return view('item.show', [
            'guild'              => $guild,
            'item'               => $item,
            'raids'              => $guild->raids,
            'receivedCharacters' => $item->receivedCharacters,
            'wishlistCharacters' => $item->wishlistCharacters,
            'itemJson'           => self::getItemJson($item->item_id),
        ]);
    }

    public function submitMassInput($guildSlug) {
        $guild = Guild::where('slug', $guildSlug)->with([
            'members' => function ($query) {
                    return $query->where('members.user_id', Auth::id());
                },
            'characters',
            ])->firstOrFail();

        $currentMember = $guild->members->where('user_id', Auth::id())->first();

        // TODO: Keep this style of permissions check?
        if (!$currentMember) {
            abort(404, 'Not a member of that guild.');
        }

        $validationRules =  [
            'items.*.id'            => 'nullable|integer|exists:items,item_id',
            'items.*.character_id'  => 'nullable|integer|exists:characters,id',

        ];

        $this->validate(request(), $validationRules);

        // TODO: permissions for mass assigning items in this guild?

        $warnings = '';
        $rows = [];
        $now = getDateTime();

        $addedCount  = 0;
        $failedCount = 0;

        foreach (request()->input('items') as $item) {
            if ($item['id']) {
                if ($guild->characters->contains('id', $item['character_id'])) {
                    $rows[] = [
                        'item_id'      => $item['id'],
                        'character_id' => $item['character_id'],
                        'added_by'     => $currentMember->id,
                        'type'         => Item::TYPE_RECEIVED,
                        'order'        => '0', // Top of the list
                        'created_at'   => $now,
                    ];
                    $addedCount++;
                } else {
                    $warnings .= (isset($item['label']) ? $item['label'] : $item['id']) . ' to character ID ' . $item['character_id'] . ', ';
                    $failedCount++;
                }
            }
        }

        DB::table('character_items')->insert($rows);

        // TODO: The following items could not be assigned to characters because they were not found in the guild:

        request()->session()->flash('status', 'Successfully added ' . $addedCount . ' items. ' . $failedCount . ' failures' . ($warnings ? ': ' . rtrim($warnings, ', ') : '.'));

        return redirect()->route('guild.roster', ['guildSlug' => $guild->slug]);
    }

    /**
     * Grab the JSON for an item from Wowhead, return only the HTML for the tooltip.
     *
     * @param int $id The ID of the item to fetch.
     */
    public static function getItemJson($id) {
        $json = null;
        try {
            // Suppressing warnings with the error control operator @ (if the id doesn't exist, it will fail to open stream)
            $json = json_decode(file_get_contents('https://classic.wowhead.com/tooltip/item/' . (int)$id));
        } catch (Exception $e) {
            // Fail silently, that's okay, we just won't display the content
        }
        return $json;
    }
}
