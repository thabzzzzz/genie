<x-app-layout>
    <div class="py-12 bg-maintheme">
        <div class="w-full mx-auto">
            <h1 class="content-heading text-center heading1 mb-5">Social</h1>

            <!-- Display Current Friends -->
            <h2>Friends</h2>
            @if ($friends->isEmpty())
                <p>You don't have any friends yet.</p>
            @else
                <ul>
                    @foreach ($friends as $friend)
                        <li>{{ $friend->name }}</li>
                    @endforeach
                </ul>
            @endif

            <!-- Display Pending Friend Requests -->
            <h2>Friend Requests</h2>
            @if ($friendRequests->isEmpty())
                <p>No pending friend requests.</p>
            @else
                <ul>
                    @foreach ($friendRequests as $request)
                        <li>
                            {{ $request->sender->name }}
                            <form action="{{ route('friend.accept', $request->id) }}" method="POST">
                                @csrf
                                <button type="submit">Accept</button>
                            </form>
                            <form action="{{ route('friend.reject', $request->id) }}" method="POST">
                                @csrf
                                <button type="submit">Reject</button>
                            </form>
                        </li>
                    @endforeach
                </ul>
            @endif

        </div>
    </div>
</x-app-layout>
