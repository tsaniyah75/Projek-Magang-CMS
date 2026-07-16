<!-- Success / Error Toast -->
@if(session('success'))
    <div class="toast success-toast" id="toast-message">
        <i class="bx bxs-check-circle toast-icon"></i>
        <span class="toast-text">{{ session('success') }}</span>
        <button class="toast-close" onclick="closeToast()">&times;</button>
    </div>
@endif
@if($errors->any())
    <div class="toast error-toast" id="toast-message">
        <i class="bx bxs-error-circle toast-icon"></i>
        <span class="toast-text">
            @foreach($errors->all() as $error){{ $error }}<br>@endforeach
        </span>
        <button class="toast-close" onclick="closeToast()">&times;</button>
    </div>
@endif
