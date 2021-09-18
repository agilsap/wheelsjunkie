@include('layouts.front-navbar')
<div class="d-flex flex-row p-5 mx-5">
    <div class="d-flex flex-column">
        <div class="container-fluid">
            <div class="d-flex flex-row">
                <h2 class="text-muted font-weight-normal p-2">
                    <strong>
                        Chats
                    </strong>
                </h2>
            </div>
            <div class="d-flex flex-row h-100">
                <div class="d-flex flex-column">
                    <div class="d-flex flex-row bg-light elevation-1 border-top-1rem fixed-content">
                        <div class="d-flex flex-column border-dark border-right p-3 overflow-chat-rooms">
                            <div class="row">
                                <div class="col-sm-12 d-flex flex-row">
                                </div>
                            </div>
                            @forelse ($rooms as $room)
                            <a href="{{route('message.index',$room->room_number)}}">
                                <div class="d-flex flex-row p-2 my-1 {{ $room->is_active ? 'chat-active' : null}}">
                                    <div class="d-flex flex-column p-2">
                                        <div class="image">
                                            <img src="{{asset($room->other_end_user->profile_picture ? 'img/images/profile/'.$room->other_end_user->profile_picture : 'img/images/profile/avatar.png')}}"
                                                class="img-circle elevation-1 img-fluid" style="max-height:50px;" alt="User Image">
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column mx-3">
                                        <div class="d-flex flex-row py-1">
                                            <h5 class="display-6 p-0 m-0 text-dark">
                                                {{$room->other_end_user->name}}
                                            </h5>
                                        </div>
                                        <div class="d-flex flex-row">
                                            <p class="text-secondary">
                                                {{$room->last_text}}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            @empty
                            <div class="d-flex flex-row p-2 my-1">
                                <div class="d-flex flex-column p-2">
                                    <div class="image">
                                    </div>
                                </div>
                                <div class="d-flex flex-column mx-3">
                                    <div class="d-flex flex-row py-1">
                                    </div>
                                    <div class="d-flex flex-row">
                                    </div>
                                </div>
                            </div>
                            @endforelse
                        </div>
                        <div class="d-flex flex-column main-chat">
                            @if ($active_chat)
                                <div class="d-flex flex-row h-5 border-bottom border-dark">
                                    <div class="d-flex flex-column mx-2 p-2">
                                        <div class="image">
                                            <img src="{{asset($active_chat->profile_picture ? 'img/images/profile/'.$active_chat->profile_picture : 'img/images/profile/avatar.png')}}"
                                                class="img-circle elevation-1 img-fluid" style="max-height:50px;" alt="User Image">
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column mx-3 p-1">
                                        <h3 class="display-5 my-auto">
                                            {{$active_chat->name}}
                                        </h3>
                                    </div>
                                </div>
                            @endif
                            <div class="d-flex flex-row overflow-message" style="width: 1250px; height: 1800px;">
                                <div class="col-lg-12 p-2">
                                    @forelse ($lines as $line)
                                        @if ($line->is_right)
                                        <div class="d-flex flex-row-reverse my-1 mx-5">
                                            <p class="chat-bubble-right">
                                                {{$line->chat->message}} 
                                            </p>
                                        </div>
                                        @else
                                        <div class="d-flex flex-row my-1 mx-5">
                                            <p class="chat-bubble-left">
                                                {{$line->chat->message}}
                                            </p>
                                        </div>
                                        @endif
                                    @empty
                                    @endforelse
                                </div>
                            </div>
                            <div class="d-flex flex-row h-25 border-top border-dark p-3">
                                <div class="col-lg-12">
                                    @if ($active_chat)
                                    <form action="{{route('message.store')}}" class="form-horizontal" method="POST">
                                        @csrf
                                        <div class="form-group row">
                                            <input hidden=true type="number" name="receiver_id" value={{$active_chat->user_id}}>
                                            <div class="col-lg-11">
                                                <textarea name="text" id="text" class="p-1" style="height: 13vh; width: 100%;" placeholder="message">@if ($default_message){{$default_message}}@endif</textarea>
                                            </div>
                                            <div class="col-lg-1 text-center my-auto">
                                                <button class="remove-btn-style" type="submit">
                                                    <h1>
                                                        <i class="fas fa-paper-plane purple-brand-text"></i>
                                                    </h1>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                    @else
                                    <form action="" class="form-horizontal" method="POST">
                                        @csrf
                                        <div class="form-group row">
                                            <div class="col-lg-11">
                                                <textarea name="text" disabled id="text" class="p-1" style="height: 13vh; width: 100%;" placeholder="message"></textarea>
                                            </div>
                                            <div class="col-lg-1 text-center my-auto">
                                                <button class="remove-btn-style" disabled type="submit">
                                                    <h1>
                                                        <i class="fas fa-paper-plane purple-brand-text"></i>
                                                    </h1>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>