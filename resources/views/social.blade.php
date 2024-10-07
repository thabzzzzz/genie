<x-app-layout>
    <div class="py-12 bg-maintheme">
        <div class="w-full mx-auto">
            <h1 class="content-heading text-center heading1 mb-5">Social</h1>
            
            <!-- Current Friends Section -->
          

            <!-- Incoming Friend Requests Section -->
            <div class="friend-requests">

                <div id="fb">
                    <div id="fb-top">
                        <p><b>Current Friends</b></p>
                    </div>


                   <ul>
    @foreach ($friends as $friend)
        <li>
            @php
                // Fetch the profile customization for the friend
                $profileCustomization = $friend->profileCustomization;

                // Use the profile picture or a default image if not found
                $profileImage = $profileCustomization 
                    ? asset('profilePictures/' . $profileCustomization->profile_picture) 
                    : asset('profilePictures/profile_picture.jpg'); // Default image
            @endphp
            <img src="{{ $profileImage }}" height="50" width="50" alt="Image of {{ $friend->name }}">
            <p>{{ $friend->name }}</p>
        </li>
    @endforeach
</ul>
                    
                    
                </div>
                

                <h2>Friend Requests</h2>
                <div id="fb">
                    <div id="fb-top">
                        <p><b>Friend Requests</b> <span>Find Friends &bull; Settings</span></p>
                    </div>
                    @foreach ($friendRequests as $friendRequest)
                    <div class="friend-request-item">
                        <img src="https://s13.postimg.org/xgla0jo4n/image.jpg" height="100" width="100" alt="Image of {{ $friendRequest->sender->name }}">
                        <p id="info"><b>{{ $friendRequest->sender->name }}</b><br> <span>14 mutual friends</span></p>
                        <div id="button-block">
                            <form action="{{ route('friend.accept', $friendRequest->id) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" id="confirm">Confirm</button>
                            </form>
                            <form action="{{ route('friend.reject', $friendRequest->id) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" id="delete">Delete Request</button>
                            </form>
                        </div>
                    </div>
                    @endforeach

                    @if ($friendRequests->isEmpty())
                        <p>No friend requests at the moment.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
