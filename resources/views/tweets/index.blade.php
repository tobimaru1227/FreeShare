<x-app-layout>
    
    <x-slot name=header>Home</x-slot>
    
    <!-- フラッシュメッセージ -->
    @if(session('message'))
        <div class="flash-message">
            {{ session('message') }}
        </div>
    @endif
    
    <div class="tweet">
        <!-- 投稿データ一覧 -->
        @foreach ($tweets as $tweet)
            <div class="tweet-container">
                <!-- 投稿者の表示 -->
                <div class="user-name">{{ $tweet->user->name }}</div>
                <!-- 投稿内容の表示 -->
                <div class="tweet-content">{{ $tweet->content }}</div>
                <!-- 画像があれば表示 -->
                @if ($tweet->image)
                    <img src="{{ asset('storage/' . $tweet->image) }}" alt="投稿画像" class="tweet-image">
                @endif
                <!-- 投稿日の表示 -->
                <div class="tweet-date">{{ $tweet->created_at }}</div>

                <x-primary-button><img src="{{ asset('images/good_icon.png') }}" alt="いいね"></x-primary-button>
                <x-primary-button><img src="{{ asset('images/share_icon.png') }}" alt="リツイート"></x-primary-button>
            </div>
        @endforeach
    </div>

</x-app-layout>