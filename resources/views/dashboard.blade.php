@extends('layouts.app')
@section('title', config('app.name'))

@section('css')
@endsection

@section('content')
<div class="container-fluid container-width-capped">
    <div class="row">
        <div class="col-12 text-center mt-5 mb-5">
            <h2 class="">
                {{trans('dashboard.welcome')}}, <span class="text-discord font-weight-bold">{{ Auth::user()->discord_username }}</span>
            </h2>
            <strong>{{trans('dashboard.change_log')}}</strong> {{trans('dashboard.and')}} <strong>{{trans('dashboard.announcements')}}</strong> {{trans('dashboard.are_on_discord')}}
            <a href="{{ env('APP_DISCORD') }}" target="_blank" alt="Join the {{ env('APP_NAME') }} Discord Server" title="Join the {{ env('APP_NAME') }} Discord Server" class="">
                </a>
            <br>
            {{trans('dashboard.if_like')}} <a href="{{ route('donate') }}" class="text-patreon">{{trans('dashboard.support_on_patreon')}}</a> {{trans('dashboard.keep_free')}}
            <br>
            {{trans('dashboard.more_is_more')}}
        </div>

        <div class="col-md-8 col-sm-10 col-12 offset-md-2 offset-sm-1 text-center">
            @if ($user->members->count() > 0)
                <h3 class="font-weight-normal mb-3">
                    <span class="fas fa-fw fa-users text-muted"></span>
                    {{trans('dashboard.your_guilds')}}
                </h3>
                <ul class="no-bullet no-indent">
                    @php
                        $disabled = [];
                    @endphp
                    @foreach ($user->members as $member)
                        @if ($member->guild->disabled_at || $member->inactive_at)
                            @php
                                $disabled[] = $member;
                            @endphp
                        @else
                            <li class="bg-lightest mt-3 mb-3 p-3">
                                <span class="font-weight-light text-5 text-muted">
                                    <span class="fab fa-fw fa-battle-net"></span>
                                    {{ $expansions->where('id', $member->guild->expansion_id)->first()->name_short }}
                                </span>
                                <h2>
                                    <a href="{{ route('member.show', ['guildId' => $member->guild->id, 'guildSlug' => $member->guild->slug, 'memberId' => $member->id, 'usernameSlug' => $member->slug]) }}">
                                        <span class="text-{{ $member->guild->disabled_at ? 'danger' : getExpansionColor($member->guild->expansion_id) }} font-weight-medium">
                                            &lt;{{ $member->guild->name }}&gt;
                                        </span>
                                    </a>
                                </h2>
                                <ul class="list-inline mt-3">
                                    @foreach ($member->characters as $character)
                                        <li class="list-inline-item bg-tag rounded pt-0 pl-1 pb-1 pr-1">
                                            <a href="{{route('character.show', ['guildId' => $member->guild->id, 'guildSlug' => $member->guild->slug, 'characterId' => $character->id, 'nameSlug' => $character->slug]) }}"
                                                class="text-{{ $character->class ? strtolower($character->class) : '' }}">
                                                {{ $character->name }}
                                            </a>
                                        </li>
                                    @endforeach
                                    <li class="list-inline-item pt-0 pl-1 pb-1 pr-1">
                                        <a href="{{ route('character.showCreate', ['guildId' => $member->guild->id, 'guildSlug' => $member->guild->slug]) }}">
                                            <span class="fas fa-plus"></span>
                                            {{trans('dashboard.create_character')}}
                                        </a>
                                    </li>
                                    <li class="list-inline-item pt-0 pl-1 pb-1 pr-1">
                                        <a href="{{ route('member.showGquit', ['guildId' => $member->guild->id, 'guildSlug' => $member->guild->slug]) }}"
                                            class="text-danger font-weight-light">
                                            /gquit
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    @endforeach
                </ul>
                @if ($disabled)
                    <ul class="no-bullet no-indent">
                        <li>
                            <span class="text-muted">{{trans('dashboard.old_guilds')}}</span>
                            <br>
                            <span id="showInactiveGuilds" class="small text-muted font-italic cursor-pointer">
                                {{trans('dashboard.click_to_show')}}
                            </span>
                        </li>
                        @foreach ($disabled as $member)
                            <li class="js-inactive-guild bg-lightest mt-3 mb-3 p-3" style="display:none;">
                                <h3>
                                    <a href="{{ route('member.show', ['guildId' => $member->guild->id, 'guildSlug' => $member->guild->slug, 'memberId' => $member->id, 'usernameSlug' => $member->slug]) }}"
                                        class="text-{{ $member->guild->disabled_at ? 'danger' : getExpansionColor($member->guild->expansion_id) }} font-weight-medium">
                                        &lt;{{ $member->guild->name }}&gt;
                                    </a>
                                </h3>
                                <ul class="list-inline">
                                    @if ($member->guild->disabled_at)
                                        <li class="list-inline-item">
                                            <span class="small text-muted">{{trans('dashboard.guild_disabled')}}</span>
                                        </li>
                                    @endif
                                    @if ($member->inactive_at || $member->banned_at)
                                        <li class="list-inline-item">
                                            <span class="small text-muted">{{trans('dashboard.membership_disabled')}}</span>
                                        </li>
                                    @else
                                        <li class="list-inline-item pl-1">
                                            <a href="{{ route('member.showGquit', ['guildId' => $member->guild->id, 'guildSlug' => $member->guild->slug]) }}"
                                                class="text-danger font-weight-light">
                                                /gquit
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                        @endforeach
                    </ul>
                @endif
            @else
                <div class="mt-4 mb-4">
                    <p class="font-weight-normal pt-3 text-4">
                        {{trans('dashboard.dont_belong_to_guild')}}
                    </p>
                    <p class="font-weight-normal pt-3 text-4">
                        {{trans('dashboard.sure_to_be_discord_master')}}
                    </p>
                    <p class="small font-weight-normal pt-3">
                        {{trans('dashboard.something_wrong')}} <a href="{{ route('faq') }}">FAQ</a> {{trans('dashboard.why_see_this')}}
                    </p>
                </div>
            @endif
        </div>

        @if ($existingGuilds)
            <div class="col-md-8 col-sm-10 col-12 offset-md-2 offset-sm-1 text-center mt-3 mb-3">
                <ul class="no-bullet no-indent">
                    @foreach ($existingGuilds as $existingGuild)
                        @if (!$existingGuild->disabled_at)
                            <li class="bg-lightest mt-3 mb-3 p-3">
                                <span class="font-weight-light text-5 text-muted">
                                    <span class="fab fa-fw fa-battle-net"></span>
                                    {{ $expansions->where('id', $existingGuild->expansion_id)->first()->name_short }}
                                </span>
                                <h2>
                                    <span class="text-{{ $existingGuild->disabled_at ? 'danger' : getExpansionColor($existingGuild->expansion_id) }} font-weight-medium">
                                        &lt;{{ $existingGuild->name }}&gt;
                                    </span>
                                </h2>
                                <ul class="list-inline">
                                    <li class="list-inline-item bg-tag rounded pt-0 pl-2 pb-1 pr-2 m-2">
                                        <a href="{{ route('guild.home', ['guildId' => $existingGuild->id, 'guildSlug' => $existingGuild->slug]) }}"
                                            class="btn btn-secondary">
                                            <span class="fas fa-plus"></span>
                                            {{trans('dashboard.join_guild')}}
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="col-12 text-center mb-5">
            <div class="mb-5">
                <p class="font-weight-normal pt-3 text-4">
                    {{trans('dashboard.are_u_guildmaster')}}
                </p>
                <a class="btn btn-light" href="{{ route('guild.showRegister') }}" title="Register a Guild" rel="nofollow">
                    <img class="discord-link" src="{{ asset('images/discord-logo.svg') }}" alt="" /> {{trans('dashboard.register_guild')}}
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function () {
    $("#showInactiveGuilds").click(function () {
        $(".js-inactive-guild").toggle();
    });
});
</script>
@endsection
