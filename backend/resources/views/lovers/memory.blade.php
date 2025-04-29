<div class="container">
    <h2>Manage Memory for {{ $lover->name }}</h2>

    <!-- Nút Quay lại -->
    <a href="{{ route('lover.index') }}" class="btn btn-secondary mb-3">Back to Lover List</a>

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

    <!-- Form thêm hình ảnh -->
    @if ($lover->memories->count() < 9)
        <form action="{{ route('lover.memory.add', $lover->id) }}" method="POST" enctype="multipart/form-data" class="mb-4">
            @csrf
            <div class="form-group">
                <label for="image">Add Image:</label>
                <input type="file" id="image" name="image" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Image</button>
        </form>
    @else
        <div class="alert alert-warning">
            Each lover can only have up to 9 images.
        </div>
    @endif

    <!-- Bảng liệt kê hình ảnh -->
    <h3>Memory Images</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($memoryImages as $memory)
                <tr>
                    <td>
                        <img src="{{ asset('storage/' . $memory->image_url) }}" alt="Memory Image" width="100">
                    </td>
                    <td>
                        <!-- Nút xóa -->
                        <form action="{{ route('lover.memory.delete', ['id' => $lover->id, 'imageId' => $memory->id]) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
