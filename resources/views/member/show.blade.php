@extends('layouts.app')
@section('title', $member->username . " - " . config('app.name'))

@section('content')
<div class="container-fluid container-width-capped">
    <div class="row">
        <div class="col-xl-8 offset-xl-2 col-md-10 offset-md-1 col-12">
            <div class="row mb-3">
                <div class="col-12 pt-2 bg-lightest rounded">
                    @php
                        $raidCount = $characters->sum(function ($character) {
                            return $character->raid_count;
                        });
                        $attendancePercentage = $characters->where('raid_count', '>', 0)->sum(function ($character) {
                            return $character->attendance_percentage;
                        });
                        $attendancePercentage = $attendancePercentage ? ($attendancePercentage / $characters->where('raid_count', '>', 0)->count()) : $attendancePercentage;
                    @endphp
                    @include('member/partials/header', [
                        'discordUsername' => $member->user->discord_username,
                        'headerSize' => 1,
                        'showEdit' => $showEdit,
                        'titlePrefix' => null,
                        'showLogs' => true,
                        'attendancePercentage' => $attendancePercentage,
                        'raidCount' => $raidCount,
                    ])
                </div>
            </div>

            <div class="row mb-3 pt-3 bg-light rounded">
                <div class="col-12 mb-2">
                    <span class="font-weight-bold">
                        <span class="fas fa-fw fa-helmet-battle text-dk"></span>
                        {{trans('page.member.show.raid_history')}}
                    </span>
                </div>

                <div class="col-12 pb-3">
                    @if ($member->characters->count())
                        @php
                            $raids = collect();
                            $characeters = ($guild->is_attendance_hidden ? $member->characters : $member->charactersWithAttendance);
                            foreach ($characters as $character) {
                                $raids = $raids->merge($character->raids);
                            }
                            $raids = $raids->sortByDesc('date');
                        @endphp
                        @if ($raids->count())
                            @include('partials/raidHistoryTable', ['raids' => $raids, 'characters' => $characters, 'showOfficerNote' => ($viewOfficerNotePermission && !isStreamerMode())])
                        @else
                            {{trans('page.member.show.none')}}
                        @endif
                    @else
                        {{trans('page.member.show.none')}}
                    @endif
                </div>
            </div>

            <div class="row mb-3 pt-3 bg-light rounded">
                <div class="col-12 mb-2">
                    <span class="font-weight-bold">
                        <span class="fas fa-fw fa-user text-muted"></span>
                        {{trans('page.member.show.characters')}}
                    </span>
                </div>
                <div class="col-12">
                    <ol class="striped no-bullet no-indent">
                        @if ($showEdit)
                            <li class="pt-3 pl-3 pb-3 pr-3 rounded">
                                <a href="{{ route('character.showCreate', ['guildId' => $guild->id, 'guildSlug' => $guild->slug, 'member_id' => $member->id]) }}" class="font-weight-medium">
                                    <span class="fas fa-plus"></span>
                                    {{trans('page.member.show.create_characters')}}
                                </a>
                            </li>
                        @endif
                        @foreach ($characters->where('inactive_at', null) as $character)
                            <li class="pt-2 pl-3 pb-3 pr-3 rounded">
                                @include('character/partials/header', ['character' => $character, 'showEdit' => $showEdit, 'showEditLoot' => $showEditLoot, 'showIcon' => false, 'showOwner' => false, 'showLogs' => true, 'useDropdown' => true])
                            </li>
                        @endforeach
                        @if ($characters->whereNotNull('inactive_at')->count() > 0)
                            <li class="pt-2 pl-3 pb-3 pr-3 rounded">
                                <span class="text-muted">{{trans('page.member.show.inactive_chars')}}</span>
                                <br>
                                <span id="showInactiveCharacters" class="small text-muted font-italic cursor-pointer">
                                    {{trans('page.member.show.click_to_show')}}
                                </span>
                                <ol class="js-inactive-characters striped no-bullet no-indent" style="display:none;">
                                    @foreach ($characters->whereNotNull('inactive_at') as $character)
                                        <li class="pt-2 pl-3 pb-3 pr-3 rounded">
                                            @include('character/partials/header', ['character' => $character, 'showEdit' => $showEdit, 'showEditLoot' => $showEditLoot, 'showIcon' => false, 'showOwner' => false, 'showLogs' => true, 'useDropdown' => true])
                                        </li>
                                    @endforeach
                                </ol>
                            </li>
                        @endif
                    </ol>
                </div>
            </div>

             <div class="row mb-3 pb-3 pt-3 bg-light rounded">
                <div class="col-12 mb-2">
                    <span class="text-gold font-weight-bold">
                        <span class="fas fa-fw fa-book"></span>
                        {{trans('page.member.show.recipes')}}
                    </span>
                </div>
                <div class="col-12">
                    @if ($recipes->count() > 0)
                        <ol class="mb-0">
                            @foreach ($recipes->sortBy('name') as $item)
                                @php
                                    $itemCharacter = $characters->find($item->pivot->character_id);
                                @endphp
                                <li class="">
                                    @include('partials/item', ['wowheadLink' => false])
                                    <small class="text-muted">
                                        on
                                        <a href="{{route('character.show', ['guildId' => $guild->id, 'guildSlug' => $guild->slug, 'characterId' => $itemCharacter->id, 'nameSlug' => $itemCharacter->slug]) }}"
                                            class="text-{{ $itemCharacter->class ? str_replace('.', '-', strtolower($itemCharacter->class)) : '' }}">
                                            {{ $itemCharacter->name }}
                                        </a>
                                    </small>
                                </li>
                            @endforeach
                        </ol>
                    @else
                        —
                    @endif
                </div>
            </div>

            <form id="noteForm" role="form" method="POST" action="{{ route('member.updateNote', ['guildId' => $guild->id, 'guildSlug' => $guild->slug]) }}">
                {{ csrf_field() }}

                <input hidden name="id" value="{{ $member->id }}" />
                <div class="row mb-3 pt-3 bg-light rounded">

                    @if (count($errors) > 0)
                        <div class="col-12">
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>
                                        {{ $error }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="col-12">
                        <span class="text-muted font-weight-bold">
                            <span class="fas fa-fw fa-comment-alt-lines"></span>
                            {{trans('page.member.show.public_note')}}
                        </span>
                    </div>
                    <div class="col-12 mb-3 pl-4">
                        <span class="js-markdown-inline">{{ $member->public_note ? $member->public_note : '—' }}</span>
                        @if ($currentMember->id == $member->id || $currentMember->hasPermission('edit.officer-notes'))
                            <span class="js-show-note-edit fas fa-fw fa-pencil text-link cursor-pointer" title="edit"></span>
                        @endif
                    </div>
                    @if ($currentMember->id == $member->id || $currentMember->hasPermission('edit.officer-notes'))
                        <div class="js-note-input col-12 mb-3 pl-4" style="display:none;">
                            <div class="form-group">
                                <label for="public_note" class="font-weight-bold">
                                    <span class="sr-only">{{trans('page.member.show.public_note')}}</span>
                                    <small class="text-muted">{{trans('page.member.show.anyone_can_see')}}</small>
                                </label>
                                <textarea maxlength="140" data-max-length="140" name="public_note" rows="2" placeholder="anyone in the guild can see this" class="form-control dark">{{ old('public_note') ? old('public_note') : ($member ? $member->public_note : '') }}</textarea>
                            </div>
                        </div>
                    @endif

                    @if ($viewOfficerNotePermission)
                        <div class="col-12">
                            <span class="text-muted font-weight-bold">
                                <span class="fas fa-fw fa-shield"></span>
                                {{trans('page.member.show.officer_note')}}
                            </span>
                        </div>
                        <div class="col-12 mb-3 pl-4">
                            @if (!isStreamerMode())
                                <span class="js-markdown-inline">{{ $member->officer_note ? $member->officer_note : '—' }}</span>
                                @if ($editOfficerNotePermission)
                                    <span class="js-show-note-edit fas fa-fw fa-pencil text-link cursor-pointer" title="edit"></span>
                                @endif
                            @else
                                {{trans('page.member.show.hidden_on_stream')}}
                            @endif
                        </div>
                        @if ($editOfficerNotePermission && !isStreamerMode())
                            <div class="js-note-input col-12 mb-3 pl-4" style="display:none;">
                                <div class="form-group">
                                    <label for="officer_note" class="font-weight-bold">
                                        <span class="sr-only">{{trans('page.member.show.officer_note')}}</span>
                                        <small class="text-muted">{{trans('page.member.show.officer_can_see')}}</small>
                                    </label>
                                    <textarea maxlength="140" data-max-length="140" name="officer_note" rows="2" placeholder="only officers can see this" class="form-control dark">{{ old('officer_note') ? old('officer_note') : ($member ? $member->officer_note : '') }}</textarea>
                                </div>
                            </div>
                        @endif
                    @endif

                    {{--
                        @if ($showPersonalNote)
                            <div class="col-12">
                                <span class="text-muted font-weight-bold">
                                    <span class="fas fa-fw fa-eye-slash"></span>
                                    {{trans('page.member.show.personal_note')}}
                                </span>
                            </div>
                            <div class="col-12 mb-3 pl-4">
                                <span class="js-markdown-inline">{{ $member->personal_note ? $member->personal_note : '—' }}</span>
                                <span class="js-show-note-edit fas fa-fw fa-pencil text-link cursor-pointer" title="edit"></span>
                            </div>
                            <div class="js-note-input col-12 pl-4" style="display:none;">
                                <div class="form-group">
                                    <label for="personal_note" class="font-weight-bold">
                                        <span class="sr-only">{{trans('page.member.show.personal_note')}}</span>
                                        <small class="text-muted">{{trans('page.member.show.only_u')}}</small>
                                    </label>
                                    <textarea maxlength="2000" data-max-length="2000" name="personal_note" rows="2" placeholder="only you can see this" class="form-control dark">{{ old('personal_note') ? old('personal_note') : ($member ? $member->personal_note : '') }}</textarea>
                                </div>
                            </div>
                        @endif
                    --}}

                    <div class="js-note-input col-12 mb-3 pl-4" style="display:none;">
                        <button class="btn btn-success"><span class="fas fa-fw fa-save"></span> Save</button>
                    </div>
                </div>
            </form>

            @if ($member->id == $currentMember->id)
                <div class="row mb-3 pb-3 pt-3">
                    <div class="col-12 mb-2">
                        <a href="{{ route('member.showGquit', ['guildId' => $guild->id, 'guildSlug' => $guild->slug]) }}"
                            class="btn btn-outline-danger font-weight-light">
                            /gquit
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function () {
    warnBeforeLeaving("#noteForm");

    $("#raids").DataTable({
        "order"       : [], // Disable initial auto-sort; relies on server-side sorting
        "paging"      : true,
        "pageLength"  : 5,
        "fixedHeader" : false, // Header row sticks to top of window when scrolling down
        "columns" : [
            { "orderable" : false },
        ]
    });

    $("#showInactiveCharacters").click(function () {
        $(".js-inactive-characters").toggle();
    });
});
</script>
@endsection
