@extends('layouts.app')
@section('title',  'Guild Recipes - ' . config('app.name'))

@section('content')
<div class="container-fluid">
    <div class="row pt-2 mb-3">
        <div class="col-12 text-center pr-0 pl-0">
            <h1 class="font-weight-medium mb-0 font-blizz">
                <span class="fas fa-fw fa-book text-gold"></span>
                Guild Recipes
            </h1>
        </div>
        <div class="col-12 pr-0 pl-0">
            <div class="pr-2 pl-2">
                <ul class="list-inline mb-0">
                    <li class="list-inline-item text-muted">
                        Quick Filters:
                    </li>
                    <li class="list-inline-item font-weight-light">
                        <span data-value="" class="js-quick-filter text-link cursor-pointer">
                            <span class="fas fa-fw fa-undo"></span>
                            All
                        </span>
                    </li>
                    @if ($guild->expansion_id > 1)
                        <li class="list-inline-item">&sdot;</li>
                        <li class="list-inline-item">
                            <span data-value="design" class="js-quick-filter text-link cursor-pointer">
                                Design
                            </span>
                        </li>
                    @endif
                    <li class="list-inline-item">&sdot;</li>
                    <li class="list-inline-item">
                        <span data-value="enchant" class="js-quick-filter text-link cursor-pointer">
                            Enchant
                        </span>
                    </li>
                    <li class="list-inline-item">&sdot;</li>
                    <li class="list-inline-item">
                        <span data-value="formula" class="js-quick-filter text-link cursor-pointer">
                            Formula
                        </span>
                    </li>
                    <li class="list-inline-item">&sdot;</li>
                    <li class="list-inline-item">
                        <span data-value="pattern" class="js-quick-filter text-link cursor-pointer">
                            Pattern
                        </span>
                    </li>
                    <li class="list-inline-item">&sdot;</li>
                    <li class="list-inline-item">
                        <span data-value="plans" class="js-quick-filter text-link cursor-pointer">
                            Plans
                        </span>
                    </li>
                    <li class="list-inline-item">&sdot;</li>
                    <li class="list-inline-item">
                        <span data-value="recipe" class="js-quick-filter text-link cursor-pointer">
                            Recipe
                        </span>
                    </li>
                    <li class="list-inline-item">&sdot;</li>
                    <li class="list-inline-item">
                        <span data-value="schematic" class="js-quick-filter text-link cursor-pointer">
                            Schematic
                        </span>
                    </li>
                </ul>
            </div>
            <div class="col-12 pb-3 pr-2 pl-2 rounded">
                <table id="recipes" class="table table-border table-hover stripe">
                    <thead>
                        <tr>
                            <th>
                                <span class="fas fa-fw fa-book text-muted"></span>
                                Recipe
                            </th>
                            <th>
                                <span class="fas fa-fw fa-users text-muted"></span>
                                Characters
                            </th>
                            <th>
                                <span class="fas fa-fw fa-comment-alt-lines text-muted"></span>
                                Notes
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $item)
                            <tr>
                                <td>
                                    <ul class="no-indent no-bullet">
                                        <li>
                                            @include('partials/item', ['wowheadLink' => false])
                                        </li>
                                    </ul>
                                </td>
                                <td>
                                    <ul class="list-inline">
                                        @foreach($item->receivedAndRecipeCharacters->sortBy('name') as $character)
                                            @include('member/partials/listMemberCharacter')
                                        @endforeach
                                    </ul>
                                </td>
                                <td>
                                    @if (!$item->guild_note && !$item->guild_priority)
                                        —
                                    @else
                                        <div>
                                            <span class="js-markdown-inline">{{ $item->guild_note ? $item->guild_note : '' }}</span>
                                        </div>
                                        <div>
                                            <span class="js-markdown-inline">{{ $item->guild_priority ? $item->guild_priority : '' }}</span>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function () {
    datatable = $("#recipes").DataTable({
        "order"  : [], // Disable initial auto-sort; relies on server-side sorting
        "paging" : false,
        "fixedHeader" : true, // Header row sticks to top of window when scrolling down
        "columns" : [
            null,
            { "orderable" : false },
            { "orderable" : false },
        ]
    });

    $(".js-quick-filter").click(function () {
        let value = $(this).data('value');
        $("#recipes").DataTable().column(0).search(value).draw();
    });
});
</script>
@endsection

