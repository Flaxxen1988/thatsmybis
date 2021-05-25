@extends('layouts.app')
@section('title', (!$character ? "Create" : "Edit") . " Character - " . config('app.name'))

@section('content')
<div class="container-fluid container-width-capped">
    <div class="row">
        <div class="col-xl-8 offset-xl-2 col-md-10 offset-md-1 col-12">
            <div class="row mb-3">
                @if ($character)
                    <div class="col-12 pt-2 bg-lightest rounded">
                        @include('character/partials/header', ['headerSize' => 1, 'showEdit' => false, 'titlePrefix' => ($character ? 'Edit ' : 'Create ')])
                    </div>
                @else
                    <div class="col-12 pt-2 mb-2">
                        <h1 class="font-weight-medium ">{{trans('page.character.edit.create')}}</h1>
                    </div>
                @endif
            </div>

            @if (count($errors) > 0)
                <ul class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <li>
                            {{ $error }}
                        </li>
                    @endforeach
                </ul>
            @endif
            <form id="editForm" class="form-horizontal" role="form" method="POST" action="{{ route(($character ? 'character.update' : 'character.create'), ['guildId' => $guild->id, 'guildSlug' => $guild->slug]) }}">
                {{ csrf_field() }}

                <input hidden name="id" value="{{ $character ? $character->id : '' }}" />
                <input hidden name="create_more" value="{{ $createMore ? 1 : 0 }}" />

                <div class="row">
                    <div class="col-12 pt-2 pb-1 mb-3 bg-light rounded">
                        <div class="row mb-4">
                            <div class="col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="name" class="font-weight-bold">
                                        <span class="text-muted fas fa-fw fa-user"></span>
                                        {{trans('page.character.edit.character_name')}}
                                    </label>
                                    <input name="name"
                                        maxlength="40"
                                        type="text"
                                        class="form-control dark"
                                        placeholder="eg. Gurgthock"
                                        value="{{ old('name') ? old('name') : ($character ? $character->name : '') }}" />
                                </div>
                            </div>

                            @if ($currentMember->hasPermission('edit.characters'))
                                <div class="col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="member_id" class="font-weight-bold">

                                            {{trans('page.character.edit.guild_member')}}
                                        </label>
                                        <div class="form-group">
                                            <select name="member_id" class="form-control dark selectpicker" data-live-search="true">
                                                <option value="">
                                                    —
                                                </option>

                                                @foreach ($guild->members as $member)
                                                    <option value="{{ $member->id }}"
                                                        data-tokens="{{ $member->id }}"
                                                        {{ old('member_id') ? (old('member_id') == $member->id ? 'selected' : '') : ($character && $character->member_id == $member->id ? 'selected' : (isset($memberId) && $memberId == $member->id ? 'selected' : '')) }}>
                                                        {{ $member->username }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="row mb-4">
                            <div class="col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="class" class="font-weight-bold">
                                        {{trans('page.character.edit.class')}}
                                    </label>
                                    <div class="form-group">
                                        <select name="class" class="form-control dark">
                                            <option value="">
                                                —
                                            </option>

                                            @foreach (App\Character::classes($guild->expansion_id) as $class)
                                                <option value="{{ $class }}" class="text-{{ str_replace('.','-', strtolower($class)) }}-important"
                                                    {{ old('class') ? (old('class') == $class ? 'selected' : '') : ($character && $character->class == $class ? 'selected' : '') }}>
                                                    {{ trans($class) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="spec" class="font-weight-bold">
                                        {{trans('page.character.edit.spec')}}
                                    </label>
                                    <input name="spec"
                                        maxlength="50"
                                        type="text"
                                        class="form-control dark"
                                        placeholder="eg. Fury Prot"
                                        value="{{ old('spec') ? old('spec') : ($character ? $character->spec : '') }}" />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="race" class="font-weight-bold">
                                        {{trans('page.character.edit.race')}}
                                    </label>
                                    <div class="form-group">
                                        <select name="race" class="form-control dark">
                                            <option value="" selected>
                                                —
                                            </option>

                                            @foreach (App\Character::races($guild->expansion_id) as $race)
                                                <option value="{{ $race }}"
                                                    {{ old('race') ? (old('race') == $race ? 'selected' : '') : ($character && $character->race == $race ? 'selected' : '') }}>
                                                    {{ trans($race) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-3 col-6">
                                <div class="form-group">
                                    <label for="level" class="font-weight-bold">
                                        Level
                                    </label>
                                    <input name="level"
                                        type="number"
                                        min="1"
                                        max="{{ $guild->getMaxLevel() }}"
                                        class="form-control dark"
                                        placeholder="0"
                                        value="{{ old('level') ? old('level') : ($character ? $character->level : $guild->getMaxLevel()) }}" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-3 pb-1 pt-2 bg-light rounded">
                    <div class="col-sm-6 col-12">
                        <div class="form-group">
                            <label for="raid_group_id" class="font-weight-bold">
                                <span class="fas fa-fw fa-helmet-battle text-dk"></span>
                                {{trans('page.character.edit.raid_group')}}
                            </label>
                            <div class="form-group">
                                <select name="raid_group_id" class="form-control dark">
                                    <option value="" selected>
                                        —
                                    </option>

                                    @foreach ($guild->raidGroups as $raidGroup)
                                        <option value="{{ $raidGroup->id }}"
                                            style="color:{{ $raidGroup->getColor() }};"
                                            {{ old('raid_group_id') ? (old('raid_group_id') == $raidGroup->id ? 'selected' : '') : ($character && $character->raidGroup && $character->raidGroup->id == $raidGroup->id ? 'selected' : '') }}>
                                            {{ $raidGroup->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-3 pb-1 pt-2 bg-light rounded">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="class" class="font-weight-bold">
                                        <span class="text-muted fas fa-fw fa-flower-daffodil"></span>
                                        {{trans('page.character.edit.profession_1')}}
                                    </label>
                                    <div class="form-group">
                                        <select name="profession_1" class="form-control dark">
                                            <option value="" selected>
                                                —
                                            </option>

                                            @foreach (App\Character::professions($guild->expansion_id) as $profession)
                                                <option value="{{ $profession }}"
                                                    {{ old('profession_1') ? (old('profession_1') == $profession ? 'selected' : '') : ($character && $character->profession_1 == $profession ? 'selected' : '') }}>
                                                    {{ trans($profession) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="class" class="font-weight-bold">
                                        {{trans('page.character.edit.profession_2')}}
                                    </label>
                                    <div class="form-group">
                                        <select name="profession_2" class="form-control dark">
                                            <option value="" selected>
                                                —
                                            </option>

                                            @foreach (App\Character::professions($guild->expansion_id) as $profession)
                                                <option value="{{ $profession }}"
                                                    {{ old('profession_2') ? (old('profession_2') == $profession ? 'selected' : '') : ($character && $character->profession_2 == $profession ? 'selected' : '') }}>
                                                    {{ trans($profession) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if ($guild->expansion_id === 1)
                            <div class="row mt-4">
                                <div class="col-sm-3 col-6">
                                    <div class="form-group">
                                        <label for="rank" class="font-weight-bold">
                                            <span class="text-muted fas fa-fw fa-swords"></span>
                                            {{trans('page.character.edit.rank')}}
                                        </label>
                                        <input name="rank"
                                            type="number"
                                            min="1"
                                            max="14"
                                            class="form-control dark"
                                            placeholder="—"
                                            value="{{ old('rank') ? old('rank') : ($character ? $character->rank : '') }}" />
                                    </div>
                                </div>


                                <div class="col-sm-3 col-6">
                                    <div class="form-group">
                                        <label for="rank_goal" class="font-weight-bold">
                                            {{trans('page.character.edit.rank_goal')}}
                                        </label>
                                        <input name="rank_goal"
                                            type="number"
                                            min="1"
                                            max="14"
                                            class="form-control dark"
                                            placeholder="—"
                                            value="{{ old('rank_goal') ? old('rank_goal') : ($character ? $character->rank_goal : '') }}" />
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="row mb-3 pb-1 pt-2 bg-light rounded">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="public_note" class="font-weight-bold">
                                <span class="text-muted fas fa-fw fa-comment-alt-lines"></span>
                                {{trans('page.character.edit.public_note')}}
                                <small class="text-muted">{{trans('page.character.edit.anyone_can_see')}}</small>
                            </label>
                            <textarea maxlength="140" data-max-length="140" name="public_note" rows="2" placeholder="{{trans('page.character.edit.anyone_can_see')}}" class="form-control dark">{{ old('public_note') ? old('public_note') : ($character ? $character->public_note : '') }}</textarea>
                        </div>
                    </div>

                    @if ($currentMember->hasPermission('edit.officer-notes'))
                        <div class="col-12 mt-4">
                            <div class="form-group">
                                <label for="officer_note" class="font-weight-bold">
                                    <span class="text-muted fas fa-fw fa-shield"></span>
                                    {{trans('page.character.edit.officer_note')}}
                                    <small class="text-muted">{{trans('page.character.edit.officer_can_see')}}</small>
                                </label>
                                @if (isStreamerMode())
                                    {{trans('page.character.edit.hidden_on_stream')}}
                                @else
                                    <textarea maxlength="140" data-max-length="140" name="officer_note" rows="2" placeholder="{{trans('page.character.edit.officer_can_see')}}" class="form-control dark">{{ old('officer_note') ? old('officer_note') : ($character ? $character->officer_note : '') }}</textarea>
                                @endif
                            </div>
                        </div>
                    @endif

                    {{--
                        @if ($currentMember->id == $character->member_id)
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="personal_note" class="font-weight-bold">
                                        <span class="text-muted fas fa-fw fa-eye-slash"></span>
                                        {{trans('page.character.edit.personal_note')}}
                                        <small class="text-muted">{{trans('page.character.edit.only_u')}}</small>
                                    </label>
                                    <textarea maxlength="2000" data-max-length="2000" name="personal_note" rows="2" placeholder="{{trans('page.character.edit.only_u')}}" class="form-control dark">{{ old('personal_note') ? old('personal_note') : ($character ? $character->personal_note : '') }}</textarea>
                                </div>
                            </div>
                        @endif
                    --}}
                </div>
                <div class="row mb-3 pt-2 pb-1 bg-light rounded">
                    @if ($character && ($currentMember->hasPermission('inactive.characters') || $currentMember->id == $character->member_id))
                        <div class="col-6">
                            <div class="form-group mb-0">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="inactive_at" value="1" class="" autocomplete="off"
                                            {{ old('inactive_at') && old('inactive_at') == 1 ? 'checked' : ($character->inactive_at ? 'checked' : '') }}>
                                            {{trans('page.character.edit.archive')}} <small class="text-muted">{{trans('page.character.edit.not_visible')}}</small>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-0">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="is_alt" value="1" class="" autocomplete="off"
                                            {{ old('is_alt') && old('is_alt') == 1 ? 'checked' : ($character->is_alt ? 'checked' : '') }}>
                                        {{trans('page.character.edit.alt_char')}} <small class="text-muted"></small>{{trans('page.character.edit.tagged_as_alt')}}
                                    </label>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="col-12">
                            <div class="form-group mb-0">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="is_alt" value="1" class="" autocomplete="off">
                                        {{trans('page.character.edit.alt_char')}} <small class="text-muted">{{trans('page.character.edit.tagged_as_alt')}}</small>
                                    </label>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <button class="btn btn-success"><span class="fas fa-fw fa-save"></span> {{trans('page.character.edit.save')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(() => warnBeforeLeaving("#editForm"));
</script>
@endsection
