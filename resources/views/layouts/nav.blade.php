<nav class="navbar navbar-expand-md navbar-dark">
    <span class="{{ isset($guild) ? 'navbar-brand-guild' : 'navbar-brand' }}" href="{{ route('home') }}">
        <span class="font-weight-bold">
            @php
                $logoColor = 'white';
                if (isset($guild)) {
                    if ($guild->disabled_at) {
                        $logoColor = 'danger';
                    } else{
                        $logoColor = getExpansionColor($guild->expansion_id);
                    }
                }
            @endphp
            <a href="{{ route('home') }}" class="text-{{ $logoColor }}"
                title="{{ isset($guild) && $guild->disabled_at ? 'guild is disabled' : '' }}">
                {!! isset($guild) && $guild->name ? $guild->name : env('APP_NAME') !!}
            </a>
            <a href="{{ route('toggleStreamerMode') }}" class="text-white">
                <span class="fa-fw {!! isStreamerMode() ? 'fas fa-shield-alt' : 'fal fa-shield' !!}"></span>
            </a>
        </span>
    </span>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            @if (Auth::user() && isset($guild) && $guild)

                @php
                    $menuColor = ($currentMember->guild_id != $guild->id ? 'text-danger' : '' );
                @endphp

                @if ($currentMember->guild_id == $guild->id)
                    <li class="nav-item {{ in_array(Route::currentRouteName(), ['member.edit', 'member.show']) && $currentMember->id == (isset($member) ? $member->id : null) ? 'active' : '' }}">
                        <a class="nav-link {{ $menuColor }}" href="{{ route('member.show', ['guildId' => $guild->id, 'guildSlug' => $guild->slug, 'memberId' => $currentMember->id, 'usernameSlug' => $currentMember->slug]) }}">
                            {{trans('nav.profile')}}
                        </a>
                    </li>
                @elseif ($currentMember->guild_id != $guild->id)
                    <li class="nav-item">
                        <a class="nav-link">
                            <span class="fa-fw fas fa-exclamation-triangle text-danger"></span>
                        </a>
                    </li>
                @endif

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ $menuColor }} {{ in_array(Route::currentRouteName(), ['guild.item.list']) ? 'active font-weight-bold' : '' }}" href="#" id="lootNavDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{trans('nav.loot.loot')}}
                    </a>
                    <div class="dropdown-menu" aria-labelledby="lootNavDropdown">
                        @if ($guild->expansion_id == 1)
                            <a class="dropdown-item" href="{{ route('guild.item.list', ['guildId' => $guild->id, 'guildSlug' => $guild->slug, 'instanceSlug' => 'zulgurub']) }}">
                                {{trans('page.raids.zul_gurub')}}
                            </a>
                            <a class="dropdown-item" href="{{ route('guild.item.list', ['guildId' => $guild->id, 'guildSlug' => $guild->slug, 'instanceSlug' => 'ruins-of-ahnqiraj']) }}">
                                {{trans('page.raids.aq40')}}
                            </a>
                            <a class="dropdown-item" href="{{ route('guild.item.list', ['guildId' => $guild->id, 'guildSlug' => $guild->slug, 'instanceSlug' => 'world-bosses']) }}">
                                {{trans('page.raids.worldbosses')}}
                            </a>
                            <a class="dropdown-item" href="{{ route('guild.item.list', ['guildId' => $guild->id, 'guildSlug' => $guild->slug, 'instanceSlug' => 'molten-core']) }}">
                                {{trans('page.raids.moltencore')}}
                            </a>
                            <a class="dropdown-item" href="{{ route('guild.item.list', ['guildId' => $guild->id, 'guildSlug' => $guild->slug, 'instanceSlug' => 'onyxias-lair']) }}">
                                {{trans('page.raids.ony_classic')}}
                            </a>
                            <a class="dropdown-item" href="{{ route('guild.item.list', ['guildId' => $guild->id, 'guildSlug' => $guild->slug, 'instanceSlug' => 'blackwing-lair']) }}">
                                {{trans('page.raids.bwl')}}
                            </a>
                            <a class="dropdown-item" href="{{ route('guild.item.list', ['guildId' => $guild->id, 'guildSlug' => $guild->slug, 'instanceSlug' => 'temple-of-ahnqiraj']) }}">
                                {{trans('page.raids.aq20')}}
                            </a>
                            <a class="dropdown-item" href="{{ route('guild.item.list', ['guildId' => $guild->id, 'guildSlug' => $guild->slug, 'instanceSlug' => 'naxxramas']) }}">
                                {{trans('page.raids.naxx')}}
                            </a>
                        @elseif ($guild->expansion_id == 2)
                            <a class="dropdown-item" href="{{ route('guild.item.list', ['guildId' => $guild->id, 'guildSlug' => $guild->slug, 'instanceSlug' => 'karazhan']) }}">
                                {{trans('page.raids.karazhan')}}
                            </a>
                            <a class="dropdown-item" href="{{ route('guild.item.list', ['guildId' => $guild->id, 'guildSlug' => $guild->slug, 'instanceSlug' => 'gruuls-lair']) }}">
                                {{trans('page.raids.gruul')}}
                            </a>
                            <a class="dropdown-item" href="{{ route('guild.item.list', ['guildId' => $guild->id, 'guildSlug' => $guild->slug, 'instanceSlug' => 'magtheridons-lair']) }}">
                                {{trans('page.raids.magtheridon')}}
                            </a>
                            <a class="dropdown-item" href="{{ route('guild.item.list', ['guildId' => $guild->id, 'guildSlug' => $guild->slug, 'instanceSlug' => 'serpentshrine-cavern']) }}">
                                {{trans('page.raids.ssc')}}
                            </a>
                            <a class="dropdown-item" href="{{ route('guild.item.list', ['guildId' => $guild->id, 'guildSlug' => $guild->slug, 'instanceSlug' => 'hyjal-summit']) }}">
                                {{trans('page.raids.hyjal')}}
                            </a>
                            <a class="dropdown-item" href="{{ route('guild.item.list', ['guildId' => $guild->id, 'guildSlug' => $guild->slug, 'instanceSlug' => 'tempest-keep']) }}">
                                {{trans('page.raids.tempest_keep')}}
                            </a>
                            <a class="dropdown-item" href="{{ route('guild.item.list', ['guildId' => $guild->id, 'guildSlug' => $guild->slug, 'instanceSlug' => 'black-temple']) }}">
                                {{trans('page.raids.black_temple')}}
                            </a>
                            <a class="dropdown-item" href="{{ route('guild.item.list', ['guildId' => $guild->id, 'guildSlug' => $guild->slug, 'instanceSlug' => 'zulaman']) }}">
                                {{trans('page.raids.zul_aman')}}
                            </a>
                            <a class="dropdown-item" href="{{ route('guild.item.list', ['guildId' => $guild->id, 'guildSlug' => $guild->slug, 'instanceSlug' => 'sunwell-plateau']) }}">
                                {{trans('page.raids.sunwell')}}
                            </a>
                            <a class="dropdown-item" href="{{ route('guild.item.list', ['guildId' => $guild->id, 'guildSlug' => $guild->slug, 'instanceSlug' => 'bc-world-bosses']) }}">
                                {{trans('page.raids.worldbosses')}}
                            </a>
                        @endif
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('guild.recipe.list', ['guildId' => $guild->id, 'guildSlug' => $guild->slug]) }}">
                            {{trans('nav.loot.guild_recipes')}}
                        </a>
                        <a class="dropdown-item text-muted" href="{{ route('guild.loot.wishlist', ['guildId' => $guild->id, 'guildSlug' => $guild->slug]) }}">
                            {{trans('nav.loot.wide_wishlists')}}
                        </a>
                    </div>
                </li>

                <li class="nav-item {{ in_array(Route::currentRouteName(), ['guild.roster']) ? 'active' : '' }}">
                    <a class="nav-link {{ $menuColor }}" href="{{ route('guild.roster', ['guildId' => $guild->id, 'guildSlug' => $guild->slug]) }}">{{trans('nav.roster')}}</a>
                </li>

                {{-- Why hello there... yes. Yes, there is a 'news' page. No, I don't quite think it's ready for the mainstream yet.
                <li class="nav-item {{ in_array(Route::currentRouteName(), ['guild.news']) ? 'active' : '' }}">
                    <a class="nav-link {{ $menuColor }}" href="{{ route('guild.news', ['guildId' => $guild->id, 'guildSlug' => $guild->slug]) }}">News</a>
                </li>
                --}}

                {{-- Yep, there's support for a calendar...
                @if ($guild->calendar_link)
                    <li class="nav-item {{ in_array(Route::currentRouteName(), ['guild.calendar']) ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('guild.calendar', ['guildId' => $guild->id, 'guildSlug' => $guild->slug]) }}">Calendar</a>
                    </li>
                @endif
                --}}
                {{-- Why yes, there's a section for hosting resources such as guides... but it's just not time yet!
                <li class="nav-item {{ in_array(Route::currentRouteName(), ['contentIndex', 'showContent']) ? 'active' : '' }}">
                    <a class="nav-link {{ $menuColor }}" href="{{ route('contentIndex', ['guildId' => $guild->id, 'guildSlug' => $guild->slug]) }}">Resources</a>
                </li>
                --}}

                @if ($currentMember->hasPermission('edit.raid-loot'))
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ $menuColor }} {{ in_array(Route::currentRouteName(), ['guild.raids.edit', 'guild.raids.list', 'guild.raids.new', 'guild.raids.show', 'item.massInput']) ? 'active font-weight-bold' : '' }}" href="#" id="raidNavDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{trans('nav.raids.raids')}}
                        </a>
                        <div class="dropdown-menu" aria-labelledby="raidNavDropdown">
                            <a class="dropdown-item" href="{{ route('guild.raids.list', ['guildId' => $guild->id, 'guildSlug' => $guild->slug]) }}">
                                {{trans('nav.raids.list')}}
                            </a>
                            <a class="dropdown-item" href="{{ route('item.massInput', ['guildId' => $guild->id, 'guildSlug' => $guild->slug]) }}">
                                {{trans('nav.raids.assign_loot')}}
                            </a>
                            <a class="dropdown-item" href="{{ route('guild.raids.create', ['guildId' => $guild->id, 'guildSlug' => $guild->slug]) }}">
                                {{trans('nav.raids.create')}}
                            </a>
                        </div>
                    </li>
                @else
                    <li class="nav-item {{ in_array(Route::currentRouteName(), ['guild.raids.list']) ? 'active' : '' }}">
                        <a class="nav-link {{ $menuColor }}" href="{{ route('guild.raids.list', ['guildId' => $guild->id, 'guildSlug' => $guild->slug]) }}">{{trans('nav.raids.raids')}}</a>
                    </li>
                @endif

                <li class="nav-item {{ in_array(Route::currentRouteName(), ['guild.auditLog']) ? 'active' : '' }}">
                    <a class="nav-link {{ $menuColor }}" href="{{ route('guild.auditLog', ['guildId' => $guild->id, 'guildSlug' => $guild->slug]) }}">{{trans('nav.audit')}}</a>
                </li>

                @php
                    $viewRoles      = $currentMember->hasPermission('view.discord-roles');
                    $viewRaids      = $currentMember->hasPermission('view.raids');
                    $editCharacters = $currentMember->hasPermission('edit.characters');
                    $editGuild      = $currentMember->hasPermission('edit.guild');
                    $editItems      = $currentMember->hasPermission('edit.items');
                    $editPrios      = $currentMember->hasPermission('edit.prios');
                @endphp

                @if ($viewRoles || $viewRaids || $editCharacters || $editGuild || $editItems || $editPrios)
                    <li class="nav-item dropdown">
                        <a class="nav-link {{ $menuColor }} dropdown-toggle" href="#" id="adminNavDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{trans('nav.admin.admin')}}
                        </a>
                        <div class="dropdown-menu" aria-labelledby="adminNavDropdown">


                            @if ($editGuild)
                                <a class="dropdown-item" href="{{ route('guild.settings', ['guildId' => $guild->id, 'guildSlug' => $guild->slug]) }}">
                                    {{trans('nav.admin.settings')}}
                                </a>
                            @endif

                            <a class="dropdown-item" href="{{ route('guild.exports', ['guildId' => $guild->id, 'guildSlug' => $guild->slug]) }}">
                                {{trans('nav.admin.exports')}}
                            </a>

                            <a class="dropdown-item" href="{{ route('guild.members.list', ['guildId' => $guild->id, 'guildSlug' => $guild->slug]) }}">
                                {{trans('nav.admin.members')}}
                            </a>

                            @if ($viewRaids)
                                <a class="dropdown-item" href="{{ route('guild.raidGroups', ['guildId' => $guild->id, 'guildSlug' => $guild->slug]) }}">
                                    {{trans('nav.admin.raid_groups')}}
                                </a>
                            @endif

                            @if ($viewRoles)
                                <a class="dropdown-item" href="{{ route('guild.roles', ['guildId' => $guild->id, 'guildSlug' => $guild->slug]) }}">
                                    {{trans('nav.admin.roles')}}
                                </a>
                            @endif

                            @if ($editCharacters)
                                <a class="dropdown-item" href="{{ route('character.showCreate', ['guildId' => $guild->id, 'guildSlug' => $guild->slug, 'create_more' => 1]) }}">
                                    {{trans('nav.admin.create_character')}}
                                </a>
                            @endif

                            @if ($editItems)
                                <div class="dropdown dropright">
                                    <a class="dropdown-item dropdown-toggle" href="#" id="adminItemNotes" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        {{trans('nav.item_notes')}}
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="adminItemNotes">
                                        @if ($guild->expansion_id == 1)
                                            <a class="dropdown-item" href="{{ route('guild.item.list.edit', ['guildId' => $guild->id, 'guildSlug' => $guild->slug, 'instanceSlug' => 'zulgurub']) }}">
                                                {{trans('page.raids.zul_gurub')}}
                                            </a>
                                            <a class="dropdown-item" href="{{ route('guild.item.list.edit', ['guildId' => $guild->id, 'guildSlug' => $guild->slug, 'instanceSlug' => 'ruins-of-ahnqiraj']) }}">
                                                {{trans('page.raids.aq40')}}
                                            </a>
                                            <a class="dropdown-item" href="{{ route('guild.item.list.edit', ['guildId' => $guild->id, 'guildSlug' => $guild->slug, 'instanceSlug' => 'world-bosses']) }}">
                                                {{trans('page.raids.worldbosses')}}
                                            </a>
                                            <a class="dropdown-item" href="{{ route('guild.item.list.edit', ['guildId' => $guild->id, 'guildSlug' => $guild->slug, 'instanceSlug' => 'molten-core']) }}">
                                                {{trans('page.raids.ony_classic')}}
                                            </a>
                                            <a class="dropdown-item" href="{{ route('guild.item.list.edit', ['guildId' => $guild->id, 'guildSlug' => $guild->slug, 'instanceSlug' => 'onyxias-lair']) }}">
                                                {{trans('page.raids.moltencore')}}
                                            </a>
                                            <a class="dropdown-item" href="{{ route('guild.item.list.edit', ['guildId' => $guild->id, 'guildSlug' => $guild->slug, 'instanceSlug' => 'blackwing-lair']) }}">
                                                {{trans('page.raids.bwl')}}
                                            </a>
                                            <a class="dropdown-item" href="{{ route('guild.item.list.edit', ['guildId' => $guild->id, 'guildSlug' => $guild->slug, 'instanceSlug' => 'temple-of-ahnqiraj']) }}">
                                                {{trans('page.raids.aq20')}}
                                            </a>
                                            <a class="dropdown-item" href="{{ route('guild.item.list.edit', ['guildId' => $guild->id, 'guildSlug' => $guild->slug, 'instanceSlug' => 'naxxramas']) }}">
                                                {{trans('page.raids.naxx')}}
                                            </a>
                                        @elseif ($guild->expansion_id == 2)
                                            <a class="dropdown-item" href="{{ route('guild.item.list.edit', ['guildId' => $guild->id, 'guildSlug' => $guild->slug, 'instanceSlug' => 'karazhan']) }}">
                                                {{trans('page.raids.karazhan')}}
                                            </a>
                                            <a class="dropdown-item" href="{{ route('guild.item.list.edit', ['guildId' => $guild->id, 'guildSlug' => $guild->slug, 'instanceSlug' => 'gruuls-lair']) }}">
                                                {{trans('page.raids.gruul')}}
                                            </a>
                                            <a class="dropdown-item" href="{{ route('guild.item.list.edit', ['guildId' => $guild->id, 'guildSlug' => $guild->slug, 'instanceSlug' => 'magtheridons-lair']) }}">
                                                {{trans('page.raids.magtheridon')}}
                                            </a>
                                            <a class="dropdown-item" href="{{ route('guild.item.list.edit', ['guildId' => $guild->id, 'guildSlug' => $guild->slug, 'instanceSlug' => 'serpentshrine-cavern']) }}">
                                                {{trans('page.raids.ssc')}}
                                            </a>
                                            <a class="dropdown-item" href="{{ route('guild.item.list.edit', ['guildId' => $guild->id, 'guildSlug' => $guild->slug, 'instanceSlug' => 'hyjal-summit']) }}">
                                                {{trans('page.raids.hyal')}}
                                            </a>
                                            <a class="dropdown-item" href="{{ route('guild.item.list.edit', ['guildId' => $guild->id, 'guildSlug' => $guild->slug, 'instanceSlug' => 'tempest-keep']) }}">
                                                {{trans('page.raids.tempest_keep')}}
                                            </a>
                                            <a class="dropdown-item" href="{{ route('guild.item.list.edit', ['guildId' => $guild->id, 'guildSlug' => $guild->slug, 'instanceSlug' => 'black-temple']) }}">
                                                {{trans('page.raids.black_temple')}}
                                            </a>
                                            <a class="dropdown-item" href="{{ route('guild.item.list.edit', ['guildId' => $guild->id, 'guildSlug' => $guild->slug, 'instanceSlug' => 'zulaman']) }}">
                                                {{trans('page.raids.zul_aman')}}
                                            </a>
                                            <a class="dropdown-item" href="{{ route('guild.item.list.edit', ['guildId' => $guild->id, 'guildSlug' => $guild->slug, 'instanceSlug' => 'sunwell-plateau']) }}">
                                                {{trans('page.raids.sunwell')}}
                                            </a>
                                            <a class="dropdown-item" href="{{ route('guild.item.list.edit', ['guildId' => $guild->id, 'guildSlug' => $guild->slug, 'instanceSlug' => 'bc-world-bosses']) }}">
                                                {{trans('page.raids.worldbosses')}}
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            @if ($editPrios)
                                <div class="dropdown dropright">
                                    <a class="dropdown-item dropdown-toggle" href="#" id="adminPrioDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        {{trans('nav.item_prios')}}
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="adminPrioDropdown">
                                        @if ($guild->expansion_id == 1)
                                            <a class="dropdown-item" href="{{ route('guild.prios.chooseRaidGroup', ['guildId' => $guild->id, 'guildSlug' => $guild->slug, 'instanceSlug' => 'zulgurub']) }}">
                                                {{trans('page.raids.zul_gurub')}}
                                            </a>
                                            <a class="dropdown-item" href="{{ route('guild.prios.chooseRaidGroup', ['guildId' => $guild->id, 'guildSlug' => $guild->slug, 'instanceSlug' => 'ruins-of-ahnqiraj']) }}">
                                                {{trans('page.raids.aq40')}}
                                            </a>
                                            <a class="dropdown-item" href="{{ route('guild.prios.chooseRaidGroup', ['guildId' => $guild->id, 'guildSlug' => $guild->slug, 'instanceSlug' => 'world-bosses']) }}">
                                                {{trans('page.raids.worldbosses')}}
                                            </a>
                                            <a class="dropdown-item" href="{{ route('guild.prios.chooseRaidGroup', ['guildId' => $guild->id, 'guildSlug' => $guild->slug, 'instanceSlug' => 'molten-core']) }}">
                                                {{trans('page.raids.moltencore')}}
                                            </a>
                                            <a class="dropdown-item" href="{{ route('guild.prios.chooseRaidGroup', ['guildId' => $guild->id, 'guildSlug' => $guild->slug, 'instanceSlug' => 'onyxias-lair']) }}">
                                                {{trans('page.raids.ony_classic')}}
                                            </a>
                                            <a class="dropdown-item" href="{{ route('guild.prios.chooseRaidGroup', ['guildId' => $guild->id, 'guildSlug' => $guild->slug, 'instanceSlug' => 'blackwing-lair']) }}">
                                                {{trans('page.raids.bwl')}}
                                            </a>
                                            <a class="dropdown-item" href="{{ route('guild.prios.chooseRaidGroup', ['guildId' => $guild->id, 'guildSlug' => $guild->slug, 'instanceSlug' => 'temple-of-ahnqiraj']) }}">
                                                {{trans('page.raids.aq20')}}
                                            </a>
                                            <a class="dropdown-item" href="{{ route('guild.prios.chooseRaidGroup', ['guildId' => $guild->id, 'guildSlug' => $guild->slug, 'instanceSlug' => 'naxxramas']) }}">
                                                {{trans('page.raids.naxx')}}
                                            </a>
                                        @elseif ($guild->expansion_id == 2)
                                            <a class="dropdown-item" href="{{ route('guild.prios.chooseRaidGroup', ['guildId' => $guild->id, 'guildSlug' => $guild->slug, 'instanceSlug' => 'karazhan']) }}">
                                                {{trans('page.raids.karazhan')}}
                                            </a>
                                            <a class="dropdown-item" href="{{ route('guild.prios.chooseRaidGroup', ['guildId' => $guild->id, 'guildSlug' => $guild->slug, 'instanceSlug' => 'gruuls-lair']) }}">
                                                {{trans('page.raids.gruul')}}
                                            </a>
                                            <a class="dropdown-item" href="{{ route('guild.prios.chooseRaidGroup', ['guildId' => $guild->id, 'guildSlug' => $guild->slug, 'instanceSlug' => 'magtheridons-lair']) }}">
                                                {{trans('page.raids.magtheridon')}}
                                            </a>
                                            <a class="dropdown-item" href="{{ route('guild.prios.chooseRaidGroup', ['guildId' => $guild->id, 'guildSlug' => $guild->slug, 'instanceSlug' => 'serpentshrine-cavern']) }}">
                                                {{trans('page.raids.ssc')}}
                                            </a>
                                            <a class="dropdown-item" href="{{ route('guild.prios.chooseRaidGroup', ['guildId' => $guild->id, 'guildSlug' => $guild->slug, 'instanceSlug' => 'hyjal-summit']) }}">
                                                {{trans('page.raids.hyal')}}
                                            </a>
                                            <a class="dropdown-item" href="{{ route('guild.prios.chooseRaidGroup', ['guildId' => $guild->id, 'guildSlug' => $guild->slug, 'instanceSlug' => 'tempest-keep']) }}">
                                                {{trans('page.raids.tempest_keep')}}
                                            </a>
                                            <a class="dropdown-item" href="{{ route('guild.prios.chooseRaidGroup', ['guildId' => $guild->id, 'guildSlug' => $guild->slug, 'instanceSlug' => 'black-temple']) }}">
                                                {{trans('page.raids.black_temple')}}
                                            </a>
                                            <a class="dropdown-item" href="{{ route('guild.prios.chooseRaidGroup', ['guildId' => $guild->id, 'guildSlug' => $guild->slug, 'instanceSlug' => 'zulaman']) }}">
                                                {{trans('page.raids.zul_aman')}}
                                            </a>
                                            <a class="dropdown-item" href="{{ route('guild.prios.chooseRaidGroup', ['guildId' => $guild->id, 'guildSlug' => $guild->slug, 'instanceSlug' => 'sunwell-plateau']) }}">
                                                {{trans('page.raids.sunwell')}}
                                            </a>
                                            <a class="dropdown-item" href="{{ route('guild.prios.chooseRaidGroup', ['guildId' => $guild->id, 'guildSlug' => $guild->slug, 'instanceSlug' => 'bc-world-bosses']) }}">
                                                {{trans('page.raids.worldbosses')}}
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    </li>
                @endif
                <div class="dropdown">
                    <a class="nav-link {{ $menuColor }} dropdown-toggle" href="#" id="languageNavDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{trans('nav.language.language')}}
                    </a>
                    <div class="dropdown-menu" aria-labelledby="languageNavDropdown">
                        @foreach (Config::get('languages') as $lang => $language)
                            @if ($lang != App::getLocale())
                                <a class="dropdown-item" href="{{ route('lang.switch', $lang) }}"><i class="fa fa-fw"></i>{{trans('nav.language.'.$lang)}}</a>
                            @else
                              <a class="dropdown-item" href="{{ route('lang.switch', $lang) }}"><i class="fas fa-check"></i> {{trans('nav.language.'.$lang)}}</a>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif
        </ul>
        <ul class="navbar-nav">
            <li class="nav-item dropdown">


            @if (isset($guild))
                <li class="nav-item mr-3 d-patreon-block">
                    <a class="dropdown-item text-4 text-patreon" href="https://www.patreon.com/lemmings19" target="_blank" title="Patreon donations">
                    <a href="https://www.patreon.com/lemmings19" target="_blank" class="nav-link active font-weight-bold text-patreon"
                        title="Toss a coin to your web dev">
                        <span class="fas fa-fw fa-sack"></span>
                        Support TMB
                    </a>
                </li>
            @endif
        </ul>
        <div class="my-2 my-lg-0">
            @if (Auth::guest())
                <a class="text-white" href="{{ route('discordLogin') }}" title="Sign in with Discord" rel="nofollow">
                    <span class="fal fa-fw fa-sign-in-alt"></span>
                    {{trans('nav.sign_in')}}
                </a>
            @else
                <a href="{{ route('logout') }}"
                    class="text-white"
                    onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">
                    <span class="text-grey fal fa-fw fa-sign-out"></span> {{trans('nav.sign_out')}} ({{ Auth::user()->username }})
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            @endif
        </div>
    </div>
</nav>
