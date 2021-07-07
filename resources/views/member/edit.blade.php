@extends('layouts.app')
@section('title', "Edit Profile - " . config('app.name'))

@section('content')
<div class="container-fluid container-width-capped">
    <div class="row">
        <div class="col-xl-8 offset-xl-2 col-md-10 offset-md-1 col-12">
            <div class="row mb-4">
                <div class="col-12 pt-2 bg-lightest rounded">
                    @include('member/partials/header', ['discordUsername' => $member->user->discord_username, 'showEdit' => false, 'titlePrefix' => 'Edit '])
                </div>
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
            <form id="editForm" class="form-horizontal" role="form" method="POST" action="{{ route('member.update', ['guildId' => $guild->id, 'guildSlug' => $guild->slug]) }}">
                {{ csrf_field() }}

                <input hidden name="id" value="{{ $member->id }}" />

                <div class="row mb-3 pb-1 pt-2 bg-light rounded">
                    <div class="col-sm-6 col-12">
                        <div class="form-group">
                            <label for="username" class="font-weight-bold">
                                <span class="text-muted fas fa-fw fa-user"></span>
                                {{trans('page.member.edit.username')}}
                            </label>
                            <input name="username"
                                maxlength="40"
                                type="text"
                                class="form-control dark"
                                placeholder="{{trans('page.member.edit.eg_username')}}"
                                value="{{ old('username') ? old('username') : $member->username }}" />
                        </div>
                    </div>
                </div>

                <div class="row mb-3 pb-1 pt-2 bg-light rounded">
                    <div class="col-12 mb-4">
                        <div class="form-group">
                            <label for="public_note" class="font-weight-bold">
                                <span class="text-muted fas fa-fw fa-comment-alt-lines"></span>
                                {{trans('page.member.edit.public_note')}}
                                <small class="text-muted">{{trans('page.member.edit.public_note_desc')}}</small>
                            </label>
                            <textarea maxlength="140" data-max-length="140" name="public_note" rows="2" placeholder="{{trans('page.member.edit.public_note_desc')}}" class="form-control dark">{{ old('public_note') ? old('public_note') : ($member ? $member->public_note : '') }}</textarea>
                        </div>
                    </div>

                    @if ($currentMember->hasPermission('edit.officer-notes'))
                        <div class="col-12 mb-4">
                            <div class="form-group">
                                <label for="officer_note" class="font-weight-bold">
                                    <span class="text-muted fas fa-fw fa-shield"></span>
                                    {{trans('page.member.edit.officer_note')}}
                                    <small class="text-muted">{{trans('page.member.edit.public_note_desc')}}</small>
                                </label>
                                @if (isStreamerMode())
                                    <br>
                                    {{trans('page.member.edit.streamer_hidden')}}
                                @else
                                    <textarea maxlength="140" data-max-length="140" name="officer_note" rows="2" placeholder="{{trans('page.member.edit.public_note_desc')}}" class="form-control dark">{{ old('officer_note') ? old('officer_note') : ($member ? $member->officer_note : '') }}</textarea>
                                @endif
                            </div>
                        </div>
                    @endif

                    {{--
                        <div class="col-12">
                            <div class="form-group">
                                <label for="personal_note" class="font-weight-bold">
                                    <span class="text-muted fas fa-fw fa-eye-slash"></span>
                                    {{trans('page.member.edit.personal_note')}}
                                    <small class="text-muted">{{trans('page.member.edit.personal_note_desc')}}</small>
                                </label>
                                <textarea maxlength="2000" data-max-length="2000" name="personal_note" rows="2" placeholder="{{trans('page.member.edit.personal_note_desc')}}" class="form-control dark">{{ old('personal_note') ? old('personal_note') : ($member ? $member->personal_note : '') }}</textarea>
                            </div>
                        </div>
                    --}}
                </div>

                @if (($currentMember->hasPermission('edit.characters') || $currentMember->id == $guild->user_id))
                    <div class="row mb-3 pt-2 pb-1 bg-light rounded">
                        <div class="col-12">
                            <div class="form-group mb-0">
                                <div class="checkbox">
                                    <label class="{{ $guild->is_received_locked ? '' : 'text-muted' }}">
                                        <input type="checkbox" name="is_received_unlocked" value="1" class="" autocomplete="off"
                                            {{ old('is_received_unlocked') && old('is_received_unlocked') == 1 ? 'checked' : ($member->is_received_unlocked ? 'checked' : '') }}>
                                        {{trans('page.member.edit.unlock_received_loot')}}
                                            <small class="text-muted">
                                                {{trans('page.member.edit.allow_edit_received_loot')}}
                                                <span class="font-weight-bold">{{trans('page.member.edit.overrides_guild_settings')}} {{ '('. ($guild->is_received_locked ? trans('page.member.edit.locked') : trans('page.member.edit.already_unlocked')).')' }}</span>
                                            </small>
                                    </label>
                                </div>
                            </div>
                        </div>
                        @if ($guild->is_wishlist_locked)
                            <div class="col-12">

                            </div>
                        @endif
                        <div class="col-12">
                            <div class="form-group mb-0">
                                <div class="checkbox">
                                    <label class="{{ $guild->is_wishlist_locked ? '' : 'text-muted' }}">
                                        <input type="checkbox" name="is_wishlist_unlocked" value="1" class="" autocomplete="off"
                                            {{ old('is_wishlist_unlocked') && old('is_wishlist_unlocked') == 1 ? 'checked' : ($member->is_wishlist_unlocked ? 'checked' : '') }}>
                                        {{trans('page.member.edit.unlock_wishlist')}}
                                            <small class="text-muted">
                                                allow member to edit their wishlist,
                                                <span class="font-weight-bold">{{trans('page.member.edit.overrides_guild_settings')}} {{ '('. ($guild->is_wishlist_locked ? trans('page.member.edit.locked') : trans('page.member.edit.already_unlocked')).')' }}</span>
                                            </small>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if (($currentMember->hasPermission('inactive.characters') || $currentMember->id == $guild->user_id) && $currentMember->id != $member->id)
                    <div class="row mb-3 pt-2 pb-1 bg-light rounded">
                        <div class="col-12">
                            <div class="form-group mb-0">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="inactive_at" value="1" class="" autocomplete="off"
                                            {{ old('inactive_at') && old('inactive_at') == 1 ? 'checked' : ($member->inactive_at ? 'checked' : '') }}>
                                            Archive/Kick/Ban <small class="text-muted">{{trans('page.member.edit.access_revoke')}}</small>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="form-group">
                    <button class="btn btn-success"><span class="fas fa-fw fa-save"></span> {{trans('page.member.edit.save')}}</button>
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
