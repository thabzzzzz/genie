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
                            <li style="list-style: none;">
                                <div class="friend-item">
                                    @php
                                        $profileCustomization = $friend->profileCustomization;
                                        $profileImage = $profileCustomization 
                                            ? asset('profilePictures/' . $profileCustomization->profile_picture) 
                                            : asset('profilePictures/profile_picture.jpg');
                                    @endphp
                                    <img src="{{ $profileImage }}" height="50" width="50" alt="Image of {{ $friend->name }}" class="friend-img">
                                    <!-- Make the name a link to the friend's profile -->
                                    <a href="{{ route('user.show', $friend->id) }}" class="friend-name">{{ $friend->name }}</a>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
                
                
                

<div id="fb">
    <div id="fb-top">
        <p><b>Friend Requests</b> </p>
    </div>
    @foreach ($friendRequests as $friendRequest)
        <div class="friend-request-item">
            @php
                // Fetch the profile customization for the sender
                $profileCustomization = $friendRequest->sender->profileCustomization;

                // Use the profile picture or a default image if not found
                $profileImage = $profileCustomization 
                    ? asset('profilePictures/' . $profileCustomization->profile_picture) 
                    : asset('profilePictures/profile_picture.jpg'); // Default image
            @endphp
            <img src="{{ $profileImage }}" height="100" width="100" alt="Image of {{ $friendRequest->sender->name }}">
            <p id="info"><b>{{ $friendRequest->sender->name }}</b><br> <span>14 mutual friends</span></p>
            <div id="button-block">
                <form action="{{ route('friend.accept', $friendRequest->id) }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" id="confirm">Confirm</button>
                </form>
                <form action="{{ route('friend.reject', $friendRequest->id) }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" id="delete">Reject</button>
                </form>
            </div>
        </div>
    @endforeach

    @if ($friendRequests->isEmpty())
        <p>No friend requests at the moment.</p>
    @endif
</div>

<div id="fb">
    <div id="fb-top">
        <p><b>Sent Requests</b></p>
    </div>

    @foreach ($pendingRequests as $pendingRequest)
        <div class="friend-request-item">
            @php
                // Fetch the profile customization for the receiver of the request
                $profileCustomization = $pendingRequest->receiver->profileCustomization;

                // Use the receiver's profile picture or a default image if not found
                $profileImage = $profileCustomization 
                    ? asset('profilePictures/' . $profileCustomization->profile_picture) 
                    : asset('profilePictures/profile_picture.jpg'); // Default image
            @endphp

            <!-- Display the receiver's profile image and name -->
            <img src="{{ $profileImage }}" height="100" width="100" alt="Image of {{ $pendingRequest->receiver->name }}">
            <p id="info"><b>{{ $pendingRequest->receiver->name }}</b><br> <span>Pending request</span></p>
            
            <!-- Cancel Friend Request -->
            <div id="button-block">
                <form action="{{ route('friend.cancel', $pendingRequest->id) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" id="delete">Cancel Request</button>
                </form>
            </div>
        </div>
    @endforeach

    @if ($pendingRequests->isEmpty())
        <p>No pending requests at the moment.</p>
    @endif
</div>




            </div>
        </div>
    </div>
</x-app-layout>
