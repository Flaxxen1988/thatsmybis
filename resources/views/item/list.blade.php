@extends('layouts.app')
@section('title',  trans($instance->name) . ' - ' . config('app.name'))

@section('content')

<div class="container-fluid">
    <div class="row pt-2 mb-3">
        <div class="col-12 text-center pr-0 pl-0">
            <h1 class="font-weight-medium mb-0 font-blizz">
                <span class="fas fa-fw fa-sack text-success"></span>
                {{ trans($instance->name) }}
            </h1>
            @if (!$guild)
                <p class="font-weight-bold text-gold">
                    {{trans('page.item.list.sign_in_for_prio')}}
                </p>
            @elseif ($viewPrioPermission || $viewOfficerNotesPermission)
                <ul class="list-inline">
                    @if ($viewOfficerNotesPermission)
                        <li class="list-inline-item">
                            <a href="{{ route('guild.item.list.edit', ['guildId' => $guild->id, 'guildSlug' => $guild->slug, 'instanceSlug' => $instance->slug]) }}">{{trans('page.item.list.edit_notes')}}</a>
                        </li>
                    @endif
                    @if ($viewPrioPermission)
                        <li class="list-inline-item">&sdot;</li>
                        <li class="list-inline-item">
                            <a href="{{ route('guild.prios.chooseRaidGroup', ['guildId' => $guild->id, 'guildSlug' => $guild->slug, 'instanceSlug' => $instance->slug]) }}">{{trans('page.item.list.edit_prios')}}</a>
                        </li>
                    @endif
                </ul>
            @endif
        </div>
        <div class="col-12 pr-0 pl-0">
            @include('partials/itemDatatable')
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    var items = {!! $items ? $items->toJson() : '{}' !!};
    var guild = {!! $guild ? $guild->toJson() : '{}' !!};
    var raidGroups      = {!! $raidGroups ? $raidGroups->toJson() : '{}' !!};
    var showNotes       = {{ $showNotes ? 'true' : 'false' }};
    var showOfficerNote = {{ $showOfficerNote ? 'true' : 'false' }};
    var showPrios       = {{ $showPrios ? 'true' : 'false' }};
    var showWishlist    = {{ $showWishlist ? 'true' : 'false' }};
</script>
<script src="{{ loadScript('itemList.js') }}"></script>
@endsection
