@extends('layouts.app')
@section('title', "Assign Loot - " . config('app.name'))

@php
    $maxDate = (new \DateTime())->modify('+1 day')->format('Y-m-d');

    // Iterating over 100+ characters 100+ items results in TENS OF THOUSANDS OF ITERATIONS.
    // So we're iterating over the characters only one time, saving the results, and printing them.
    $characterSelectOptions = (string)View::make('partials.characterOptions', ['characters' => $guild->characters]);
@endphp

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">

            <div class="row">
                <div class="col-12 pt-2 mb-2">
                    <h1 class="font-weight-medium">
                        <span class="fas fa-fw fa-helmet-battle text-dk"></span>
                        {{trans('page.item.massInput.assign')}}
                    </h1>
                    <small>
                        <strong>{{trans('page.item.massInput.hint')}}</strong> {{trans('page.item.massInput.hint_msg')}}
                        <br>
                        <strong>{{trans('page.item.massInput.note')}}</strong> {{trans('page.item.massInput.note_msg')}}
                    </small>
                </div>
            </div>

            <div class="row mt-4 mb-4">
                <div class="col-12 pt-2 pb-2 bg-light rounded">
                    <div class="row">
                        <div id="toggleImportArea" class="col-12 mt-3">
                            <div class="form-group">
                                <button type="button" class="js-toggle-import btn btn-primary">
                                    <span class="fas fa-fw fa-file-import"></span>
                                    {{trans('page.item.massInput.import')}}
                                </button>
                            </div>
                        </div>
                        <div id="importArea" class="col-12" style="display:none;">
                            <label for="import_textarea" class="font-weight-bold">
                                <span class="fas fa-fw fa-align-left text-muted"></span>
                                {{trans('page.item.massInput.paste')}} <abbr title="Comma Separated Value">CSV</abbr> {{trans('page.item.massInput.data')}}
                                <span class="small text-muted">{{trans('page.item.massInput.max')}} {{ $maxItems }} {{trans('page.item.massInput.rows')}}</span>
                            </label>
                            <!-- For supporting other input methods
                            <div class="tabs">
                                <div class="tab active" id="tab-string">String</div>
                                <div class="tab" id="tab-local">Local File(s)</div>
                                <div class="tab" id="tab-remote">Remote File</div>
                                <div class="tab" id="tab-unparse">JSON to CSV</div>
                            </div>
                            -->
                            <div id="input-string" class="form-group">
                                <textarea id="importTextarea"
                                    name="import_textarea"
                                    rows="20"
                                    placeholder="{{trans('page.item.massInput.csv_info')}}"
                                    class="form-control dark"
                                    autocomplete="off"></textarea>
                            </div>
                            <div class="form-group">
                                <p class="small text-muted">
                                    {{trans('page.item.massInput.support_csv_schema')}} <a href="{{ env('APP_DISCORD') }}" target="_blank">{{trans('page.item.massInput.on_disc')}}</a>.
                                </p>
                                <p class="text-danger font-weight-bold">
                                    {{trans('page.item.massInput.remove_warning')}}
                                </p>
                                <button type="button" id="submitImport" class="btn btn-warning">
                                    <span class="fas fa-fw fa-file-export"></span>
                                    {{trans('page.item.massInput.load')}}
                                </button>
                                <button type="button" class="js-toggle-import btn btn-primary">
                                    <span class="fas fa-fw fa-times-circle"></span>
                                    {{trans('page.item.massInput.nvm')}}
                                </button>
                                <div id="loading-indicator" class="mt-3 ml-5" style="display:none;">
                                    <div class="spinner-border" role="status">
                                      <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                                <div id="loaded-indicator" class="text-success font-weight-bold mt-3 ml-5" style="display:none;">
                                    Finished
                                </div>
                                <div id="status-message" class="mt-3 ml-5" style="display:none;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4 mb-4">
                <div class="col-12 pt-2 pb-2 bg-light rounded">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group mb-0">
                                <div class="checkbox">
                                    <label class="text-muted">
                                        <input type="checkbox" name="toggle_notes" value="1" class="" autocomplete="off"
                                            {{ old('toggle_notes') && old('toggle_notes') != 1 ? '' : 'checked' }}>
                                        {{trans('page.item.massInput.show_note_inputs')}}
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label class="text-muted">
                                        <input type="checkbox" name="toggle_dates" value="1" class="" autocomplete="off"
                                            {{ old('toggle_dates') && old('toggle_dates') == 1 ? 'checked' : '' }}>
                                        {{trans('page.item.massInput.show_date_inputs')}} <span class="text-muted small">{{trans('page.item.massInput.for_backdating')}}</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="default_datepicker" class="row" style="display:none;">
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="date_default" class="font-weight-bold">
                                    <span class="fas fa-fw fa-calendar-alt text-muted"></span>
                                    {{trans('page.item.massInput.set_default_date')}} <span class="text-muted small">{{trans('page.item.massInput.overwrite_date_warning')}}</span>
                                </label>
                                <input name="date_default" min="2004-09-22" max="{{ $maxDate }}" type="date" placeholder="{{trans('page.item.massInput.default_today')}}" class="form-control dark" autocomplete="off">
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <form id="itemForm" class="form-horizontal" role="form" method="POST" action="{{ route('item.massInput.submit', ['guildId' => $guild->id, 'guildSlug' => $guild->slug]) }}">
                <fieldset>
                    {{ csrf_field() }}
                    <div class="row mt-4 mb-4">

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

                        <!-- Raid Group -->
                        <div class="col-lg-3 col-sm-6 col-12 pt-2 mb-2">
                            <label for="raid_group_id font-weight-light">
                                <span class="text-muted fas fa-fw fa-helmet-battle"></span>
                                {{trans('page.item.massInput.raid_group')}}
                            </label>
                            <select name="raid_group_id" class="form-control dark">
                                <option value="">—</option>
                                @foreach ($guild->raidGroups as $raidGroup)
                                    <option value="{{ $raidGroup->id }}" style="color:{{ $raidGroup->getColor() }};">
                                        {{ $raidGroup->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Character select filter -->
                        <div class="col-lg-3 col-sm-6 col-12 pt-2 mb-2">
                            <label for="raid_group_filter font-weight-light">
                                <span class="text-muted">{{trans('page.item.massInput.character_dropdown')}}</span>
                            </label>
                            <select id="raid_group_filter" class="form-control dark">
                                <option value="">—</option>
                                @foreach ($guild->raidGroups as $raidGroup)
                                    <option value="{{ $raidGroup->id }}" style="color:{{ $raidGroup->getColor() }};">
                                        {{ $raidGroup->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 mt-3 mb-3 bg-light rounded">
                            @for ($i = 0; $i < $maxItems; $i++)
                                @php
                                    $itemId    = 'item.' . $i . '.id';
                                    $itemLabel = 'item.' . $i . '.label';
                                @endphp
                                <div class="row striped-light pb-4 pt-4 rounded {{ $i > 2 ? 'js-hide-empty' : '' }}" style="{{ ($i > 2) && old('item.' . $i . '.id') == null && old('item.' . $i . '.character_id') == null ? 'display:none;' : '' }}">

                                    <!-- Item input -->
                                    <div class="col-lg-3 col-sm-6 col-12">
                                        <div class="form-group mb-0 {{ $errors->has($itemId) ? 'text-danger font-weight-bold' : '' }}">

                                            <label for="name" class="font-weight-bold">
                                                <span class="fas fa-fw fa-sack text-success"></span>
                                                @if ($i == 0)
                                                    {{trans('page.item.massInput.item')}}
                                                @else
                                                    <span class="sr-only">
                                                        {{trans('page.item.massInput.item')}}
                                                    </span>
                                                @endif
                                            </label>

                                            <input maxlength="50" data-max-length="50" data-is-single-input="1" data-id="{{ $i }}" type="text" placeholder="item name"
                                                class="js-item-autocomplete js-input-text js-show-next form-control dark {{ $errors->has($itemId) ? 'form-danger' : '' }}" autocomplete="off"
                                                style="{{ old($itemId) ? 'display:none;' : '' }}">
                                            <span class="js-loading-indicator" style="display:none;">{{trans('page.item.massInput.searching')}}</span>&nbsp;

                                            <ul class="no-bullet no-indent mb-0">
                                                <li class="input-item {{ $errors->has($itemId) ? 'text-danger font-weight-bold' : '' }} {{ $errors->has($itemId) ? 'form-danger' : '' }}" style="{{ old($itemId) ? '' : 'display:none;' }}">
                                                    <input type="checkbox" checked name="item[{{ $i }}][id]" value="{{ old($itemId) ? old($itemId) : '' }}" autocomplete="off" style="display:none;">
                                                    <input type="checkbox" checked name="item[{{ $i }}][label]" value="{{ old($itemLabel) ? old($itemLabel) : '' }}" autocomplete="off" style="display:none;">
                                                    <button type="button" class="js-input-button close pull-left" aria-label="Close"><span aria-hidden="true" class="filter-button">&times;</span></button>&nbsp;
                                                    <span class="js-sort-handle js-input-label move-cursor text-unselectable">
                                                        @if (old($itemId))
                                                            @include('partials/item', ['itemName' =>  old($itemLabel), 'itemId' =>  old($itemId)])
                                                        @endif
                                                    </span>&nbsp;
                                                </li>
                                                @if ($errors->has($itemId))
                                                    <li class="'text-danger font-weight-bold'">
                                                        {{ $errors->first($itemId) }}
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>

                                    <!-- Character dropdown -->
                                    <div class="col-lg-2 col-sm-4 col-10">
                                        <div class="form-group mb-0 {{ $errors->has('item.' . $i . '.character_id') ? 'text-danger font-weight-bold' : '' }}">

                                            <label for="character_id" class="font-weight-bold">
                                                @if ($i == 0)
                                                    <span class="fas fa-fw fa-user text-muted"></span>
                                                    {{trans('page.item.massInput.character')}}
                                                @else
                                                    &nbsp;
                                                    <span class="sr-only">
                                                        {{trans('page.item.massInput.character')}}
                                                    </span>
                                                @endif
                                            </label>

                                            <select name="item[{{ $i }}][character_id]" class="js-show-next form-control dark {{ $errors->has('item.' . $i . '.character_id') ? 'form-danger' : '' }}" data-live-search="true" autocomplete="off">
                                                <option value="">
                                                    —
                                                </option>

                                                {{-- See the notes at the top for why the options look like this --}}
                                                @if (old('item.' . $i . '.character_id'))
                                                    @php
                                                        // Select the correct option
                                                        $options = str_replace('hack="' . old('item.' . $i . '.character_id') . '"', 'selected', $characterSelectOptions);
                                                     @endphp
                                                     {!! $options !!}
                                                @else
                                                    {!! $characterSelectOptions !!}
                                                @endif
                                            </select>

                                            @if ($errors->has('item.' . $i))
                                                <div class="'text-danger font-weight-bold'">
                                                    {{ $errors->first('item.' . $i) }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Offspec -->
                                    <div class="col-lg-1 col-sm-2 col-2">
                                        <div class="form-group">
                                            <label for="item[{{ $i }}][is_offspec]" class="font-weight-bold">
                                                @if ($i == 0)
                                                    {{trans('page.item.massInput.os')}}
                                                @else
                                                    <span class="sr-only">
                                                        {{trans('page.item.massInput.os')}}
                                                    </span>
                                                    &nbsp;
                                                @endif
                                            </label>
                                            <div class="checkbox">
                                                <label title="item is offspec">
                                                    <input type="checkbox" name="item[{{ $i }}][is_offspec]" value="1" class="js-show-next" autocomplete="off"
                                                        {{ old('item.' . $i . '.is_offspec') && old('item.' . $i . '.is_offspec') == 1  ? 'checked' : '' }}>
                                                        OS
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Note -->
                                    <div class="js-note col-lg-3 col-sm-6 col-12">
                                        <div class="form-group mb-0 {{ $errors->has('item.' . $i . '.note') ? 'text-danger font-weight-bold' : '' }}">

                                            <label for="item[{{ $i }}][note]" class="font-weight-bold">
                                                @if ($i == 0)
                                                    <span class="fas fa-fw fa-comment-alt-lines text-muted"></span>
                                                    {{trans('page.item.massInput.notes')}}
                                                    <span class="text-muted small">{{trans('page.item.massInput.optional')}}</span>
                                                @else
                                                    &nbsp;
                                                    <span class="sr-only">
                                                        {{trans('page.item.massInput.optional_note')}}
                                                    </span>
                                                @endif
                                            </label>
                                            <input name="item[{{ $i }}][note]" maxlength="140" data-max-length="140" type="text" placeholder="{{trans('page.item.massInput.note_desc')}}"
                                                class="js-show-next form-control dark {{ $errors->has('item.' . $i . '.note') ? 'form-danger' : '' }}" autocomplete="off"
                                                value="{{ old('item.' . $i . '.note') ? old('item.' . $i . '.note') : '' }}">
                                        </div>
                                    </div>

                                    <!-- Officer Note -->
                                    <div class="js-note col-lg-3 col-sm-6 col-12">
                                        <div class="form-group mb-0 {{ $errors->has('item.' . $i . '.officer_note') ? 'text-danger font-weight-bold' : '' }}">

                                            <label for="item[{{ $i }}][officer_note]" class="font-weight-bold">
                                                @if ($i == 0)
                                                    <span class="fas fa-fw fa-shield text-muted"></span>
                                                    {{trans('page.item.massInput.officer_note')}}
                                                    <span class="text-muted small">{{trans('page.item.massInput.optional')}}</span>
                                                @else
                                                    &nbsp;
                                                    <span class="sr-only">
                                                        {{trans('page.item.massInput.optional_officer_note')}}
                                                    </span>
                                                @endif
                                            </label>
                                            <input name="item[{{ $i }}][officer_note]" maxlength="140" data-max-length="140" type="text" placeholder="{{trans('page.item.massInput.officer_note')}}"
                                                class="js-show-next form-control dark {{ $errors->has('item.' . $i . '.officer_note') ? 'form-danger' : '' }}" autocomplete="off"
                                                value="{{ old('item.' . $i . '.officer_note') ? old('item.' . $i . '.officer_note') : '' }}">
                                        </div>
                                    </div>

                                    <!-- Date -->
                                    <div class="js-date col-lg-3 col-sm-6 col-12" style="{{ old('item.' . $i . '.received_at') ? '' : 'display:none;' }}">
                                        <div class="form-group mb-0 {{ $errors->has('item.' . $i . '.received_at') ? 'text-danger font-weight-bold' : '' }}">

                                            <label for="item[{{ $i }}][received_at]" class="font-weight-bold">
                                                @if ($i == 0)
                                                    <span class="fas fa-fw fa-calendar-alt text-muted"></span>
                                                    <abbr title="{{trans('page.item.massInput.rclc_date_issue')}}">{{trans('page.item.massInput.date')}}</abbr>
                                                    <span class="text-muted small">{{trans('page.item.massInput.optional')}}</span>
                                                @else
                                                    &nbsp;
                                                    <span class="sr-only">
                                                        {{trans('page.item.massInput.optional_date')}}
                                                    </span>
                                                @endif
                                            </label>
                                            <input name="item[{{ $i }}][received_at]" min="2004-09-22" max="{{ $maxDate }}" type="date" placeholder="{{trans('page.item.massInput.default_today')}}"
                                                class="js-show-next form-control dark {{ $errors->has('item.' . $i . '.received_at') ? 'form-danger' : '' }}" autocomplete="off"
                                                {{ old('item.' . $i . '.received_at') ? old('item.' . $i . '.received_at') : '' }}>
                                        </div>
                                    </div>

                                    <!-- Import ID -->
                                    <div class="js-import-id col-lg-3 col-sm-6 col-12" style="{{ old('item.' . $i . '.import_id') ? '' : 'display:none;' }}">
                                        <div class="form-group mb-0 {{ $errors->has('item.' . $i . '.received_at') ? 'text-danger font-weight-bold' : '' }}">

                                            <label for="item[{{ $i }}][import_id]" class="font-weight-bold">
                                                @if ($i == 0)
                                                    <span class="fas fa-fw fa-fingerprint text-muted"></span>
                                                        <abbr title="{{trans('page.item.massInput.uid_desc')}}">{{trans('page.item.massInput.uid')}}</abbr>
                                                    <span class="text-muted small">{{trans('page.item.massInput.optional')}}</span>
                                                @else
                                                    &nbsp;
                                                    <span class="sr-only">
                                                        {{trans('page.item.massInput.uid')}}
                                                    </span>
                                                @endif
                                            </label>
                                            <input name="item[{{ $i }}][import_id]" maxlength="20" data-max-length="20" type="text" placeholder="{{trans('page.item.massInput.uid_addon')}}"
                                                class="js-show-next form-control dark {{ $errors->has('item.' . $i . '.import_id') ? 'form-danger' : '' }}" autocomplete="off"
                                                value="{{ old('item.' . $i . '.import_id') ? old('item.' . $i . '.import_id') : '' }}">
                                        </div>
                                    </div>
                                    @if ($i == $maxItems - 1)
                                        <div class="col-12 mt-3 text-danger font-weight-bold">
                                            {{trans('page.item.massInput.max_items_added')}}
                                        </div>
                                    @endif
                                </div>
                            @endfor
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 pt-2 pb-1 mt-4 mb-4 bg-light rounded">
                            <div class="form-group mb-0">
                                <div class="checkbox">
                                    <label class="text-muted">
                                        <input type="checkbox" name="skip_missing_characters" value="1" class="" autocomplete="off"
                                            {{ (old('skip_missing_characters') && old('skip_missing_characters') == 1) ? 'checked' : '' }}>
                                        {{trans('page.item.massInput.skip_no_character')}} <abbr title="{{trans('page.item.massInput.skip_no_character_desc')}}">?</abbr>
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label class="text-muted">
                                        <input type="checkbox" name="delete_wishlist_items" value="1" class="" autocomplete="off"
                                            {{ (old('delete_wishlist_items') && old('delete_wishlist_items') == 1) || (!old('delete_wishlist_items') && $guild->is_wishlist_autopurged) ? 'checked' : '' }}>
                                        {{trans('page.item.massInput.delete_from_wishlist')}} <abbr title="{{trans('page.item.massInput.delete_from_wishlist_desc')}}">?</abbr>
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label class="text-muted">
                                        <input type="checkbox" name="delete_prio_items" value="1" class="" autocomplete="off"
                                            {{ (old('delete_prio_items') && old('delete_prio_items') == 1) || (!old('delete_prio_items') && $guild->is_prio_autopurged) ? 'checked' : '' }}>
                                        {{trans('page.item.massInput.delete_from_prio')}} <abbr title="{{trans('page.item.massInput.delete_from_prio_desc')}}">?</abbr>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <ul class="no-bullet no-indent">
                            <li class="mb-2">
                                <button class="btn btn-success" onclick="return showSubmitWarning();"><span class="fas fa-fw fa-save"></span> {{trans('page.item.massInput.submit')}}</button>
                            </li>
                            <li id="raidGroupWarning" style="display:none;">
                                <span class="text-danger">{{trans('page.item.massInput.no_raid_group')}}</span>
                            </li>
                            <li>
                                <small>{{trans('page.item.massInput.expires_warn1')}} {{ env('SESSION_LIFETIME') / 60 }} {{trans('page.item.massInput.expires_warn2')}}</small>
                            </li>
                        </ul>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    var guild    = {!! $guild->toJson() !!};
    var maxItems = {{ $maxItems }};

    function showSubmitWarning() {
        let message = "Submit?";

        if (!$("[name=raid_group_id]").val()) {
            message += " Don't forget to set a raid group!";
        }

        if ($("[name=toggle_dates]")[0].checked) {
            message += " Double-check the dates!";
        }

        return confirm(message);
    }

    $(document).ready(() => warnBeforeLeaving("#itemForm"));
</script>
<script src="{{ loadScript('itemMassInput.js') }}"></script>
@endsection
