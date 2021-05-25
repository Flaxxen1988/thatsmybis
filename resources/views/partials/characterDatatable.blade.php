<div class="pr-2 pl-2">
    <ul class="list-inline mb-0">
        <li class="list-inline-item">
            <label for="raid_group_filter font-weight-light">
                <span class="text-muted fas fa-fw fa-helmet-battle"></span>
                {{trans('page.partials.characterDatatable.raid_group')}}
            </label>
            <select id="raid_group_filter" class="form-control dark">
                <option value="">—</option>
                @foreach ($raidGroups->whereNull('disabled_at') as $raidGroup)
                    <option value="{{ $raidGroup->id }}" style="color:{{ $raidGroup->getColor() }};">
                        {{ $raidGroup->name }}
                    </option>
                @endforeach
            </select>
        </li>
        <li class=" list-inline-item">
            <label for="class_filter font-weight-light">
                <span class="text-muted fas fa-fw fa-axe-battle"></span>
                {{trans('page.partials.characterDatatable.class')}}
            </label>
            <select id="class_filter" class="form-control dark">
                <option value="">—</option>
                @foreach (App\Character::classes($guild->expansion_id) as $class)
                    <option value="{{ $class }}" class="text-{{ strtolower($class) }}-important">
                        {{ trans($class) }}
                    </option>
                @endforeach
            </select>
        </li>
        <li class="list-inline-item">
            <label for="instance_filter font-weight-light">
                <span class="text-muted fas fa-fw fa-sack"></span>
                {{trans('page.partials.characterDatatable.dungeon')}}
            </label>
            <select id="instance_filter" class="form-control dark">
                <option value="">—</option>
                @if ($guild->expansion_id == 1)
                    <option value="4">
                        {{trans('page.raids.zul_gurub')}}
                    </option>
                    <option value="5">
                        {{trans('page.raids.aq40')}}
                    </option>
                    <option value="8">
                        {{trans('page.raids.worldbosses')}}
                    </option>
                    <option value="1">
                        {{trans('page.raids.moltencore')}}
                    </option>
                    <option value="2">
                        {{trans('page.raids.ony_classic')}}
                    </option>
                    <option value="3">
                        {{trans('page.raids.bwl')}}
                    </option>
                    <option value="6">
                        {{trans('page.raids.aq20')}}
                    </option>
                    <option value="7">
                        {{trans('page.raids.naxx')}}
                    </option>
                @elseif ($guild->expansion_id == 2)
                    <option value="9">
                        {{trans('page.raids.karazhan')}}
                    </option>
                    <option value="10">
                        {{trans('page.raids.gruul')}}
                    </option>
                    <option value="11">
                        {{trans('page.raids.magtheridon')}}
                    </option>
                    <option value="12">
                        {{trans('page.raids.ssc')}}
                    </option>
                    <option value="13">
                        {{trans('page.raids.hyjal')}}
                    </option>
                    <option value="14">
                        {{trans('page.raids.tempest_keep')}}
                    </option>
                    <option value="15">
                        {{trans('page.raids.black_temple')}}
                    </option>
                    <option value="16">
                        {{trans('page.raids.zul_aman')}}
                    </option>
                    <option value="17">
                        {{trans('page.raids.sunwell')}}
                    </option>
                    <option value="18">
                        {{trans('page.raids.worldbosses')}}
                    </option>
                @endif
            </select>
        </li>

        <li class="list-inline-item font-weight-light">
            <span class="text-muted fas fa-fw fa-eye-slash"></span>
            {{trans('page.partials.characterDatatable.columns')}}
        </li>
        <li class="list-inline-item">&sdot;</li>
        <li class="list-inline-item">
            <span class="toggle-column-default text-link cursor-pointer">
                {{trans('page.partials.characterDatatable.defaults')}}
            </span>
        </li>
        <li class="list-inline-item">&sdot;</li>
        <li class="list-inline-item">
            <span class="toggle-column text-link cursor-pointer font-weight-light" data-column="1">
                <span class="text-muted fal fa-fw fa-sack"></span>
                {{trans('page.partials.characterDatatable.loot_received')}}
            </span>
        </li>
        @if ($showWishlist)
            <li class="list-inline-item">&sdot;</li>
            <li class="list-inline-item">
                <span class="toggle-column text-link cursor-pointer font-weight-light" data-column="2">
                    <span class="text-muted fal fa-fw fa-scroll-old"></span>
                    {{trans('page.partials.characterDatatable.wishlist')}}
                </span>
            </li>
        @endif
        @if ($showPrios)
            <li class="list-inline-item">&sdot;</li>
            <li class="list-inline-item">
                <span class="toggle-column text-link cursor-pointer font-weight-light" data-column="3">
                    <span class="text-muted fal fa-fw fa-sort-amount-down"></span>
                    {{trans('page.partials.characterDatatable.prios')}}
                </span>
            </li>
        @endif
        <!--
        <li class="list-inline-item">&sdot;</li>
        <li class="list-inline-item">
            <span class="toggle-column text-link cursor-pointer font-weight-light" data-column="3">
                <span class="text-muted fas fa-fw fa-book"></span>
                Recipes
            </span>
        </li>
        -->
        <!--
        <li class="list-inline-item">&sdot;</li>
        <li class="list-inline-item">
            <span class="toggle-column text-link cursor-pointer font-weight-light" data-column="4">
                <span class="text-muted fab fa-fw fa-discord"></span>
                Roles
            </span>
        </li>
        -->
        <li class="list-inline-item">&sdot;</li>
        <li class="list-inline-item">
            <span class="toggle-column text-link cursor-pointer font-weight-light" data-column="6">
                <span class="text-muted fal fa-fw fa-comment-alt-lines"></span>
                {{trans('page.partials.characterDatatable.notes')}}
            </span>
        </li>
        <li class="list-inline-item">&sdot;</li>
        <li class="list-inline-item">
            <span class="js-show-all-clipped-items text-link cursor-pointer font-weight-light" data-column="6">
                <span class="text-muted fal fa-fw fa-eye"></span>
                {{trans('page.partials.characterDatatable.show_all_loot')}}
            </span>
        </li>
    </ul>
</div>

<div class="col-12 pb-3 pr-2 pl-2 rounded">
    <table id="characterTable" class="table table-border table-hover stripe">
    </table>
</div>
