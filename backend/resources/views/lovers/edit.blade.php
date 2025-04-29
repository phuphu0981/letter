<div class="container">
    <!-- Hiển thị lỗi nếu có -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <h2>Edit Lover</h2>
    <form action="{{ route('lover.update', $lover->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ $lover->name }}" required>
        </div>
        <div class="form-group">
            <label for="avatar">Avatar:</label>
            <input type="file" id="avatar" name="avatar" class="form-control">
            @if ($lover->avatar)
                <img src="{{ asset('storage/' . $lover->avatar) }}" alt="Avatar" width="100">
            @endif
        </div>
        <div class="form-group">
            <label for="pass">Password:</label>
            <input type="password" id="pass" name="pass" class="form-control" value="{{ $lover->pass }}" required>
        </div>
        <div class="form-group">
            <label for="content_letter">Content Letter:</label>
            <textarea id="content_letter" name="content_letter" class="form-control">{{ $lover->content_letter }}</textarea>
        </div>
        <div class="form-group">
            <label for="text_profile">Text Profile:</label>
            <textarea id="text_profile" name="text_profile" class="form-control">{{ $lover->text_profile }}</textarea>
        </div>
        <div class="form-group">
            <label for="text_letter">Text Letter:</label>
            <textarea id="text_letter" name="text_letter" class="form-control">{{ $lover->text_letter }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update Lover</button>
    </form>
</div>
