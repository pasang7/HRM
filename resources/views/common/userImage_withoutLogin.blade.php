<span class="profile-pic-wrapper">
    @if($user['user']->profile_image)
        <img src="{{ asset('uploads/UserDocuments/thumbnail/'.$user['user']->profile_image) }}">
    @else 
        <img src="{{ asset('theme/images/user.png') }}">
    @endif
</span>