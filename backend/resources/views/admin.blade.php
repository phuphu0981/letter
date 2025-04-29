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

    <h2>Add a New Lover</h2>
    <form action="{{ route('lover.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="avatar">Avatar:</label>
            <input type="file" id="avatar" name="avatar" class="form-control">
        </div>
        <div class="form-group">
            <label for="pass">Password:</label>
            <input type="password" id="pass" name="pass" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="content_letter">Content Letter:</label>
            <textarea id="content_letter" name="content_letter" class="form-control"></textarea>
        </div>
        <div class="form-group">
            <label for="text_profile">Text Profile:</label>
            <textarea id="text_profile" name="text_profile" class="form-control"></textarea>
        </div>
        <div class="form-group">
            <label for="text_letter">Text Letter:</label>
            <textarea id="text_letter" name="text_letter" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Add Lover</button>
    </form>

    <hr>

    <h2>Lover List</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Avatar</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($lovers as $lover)
                <tr>
                    <td>{{ $lover->id }}</td>
                    <td>{{ $lover->name }}</td>
                    <td>
                        @if ($lover->avatar)
                            <img src="{{ asset('storage/' . $lover->avatar) }}" alt="Avatar" width="50">
                        @else
                            No Avatar
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('lover.edit', $lover->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('lover.destroy', $lover->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                        <a href="{{ route('lover.memory', $lover->id) }}" class="btn btn-info btn-sm">Manage Memory</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>