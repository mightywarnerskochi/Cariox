@extends('admin.layouts.app')

@section('content')


<div class="dashboard-content">

    @if(session('success'))
        <div style="background-color: #d1fae5; color: #065f46; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
            {{ session('success') }}
        </div>
    @endif

    <!-- Base Banner Form -->
    <div class="section-container">
        <div class="section-header">
            Section heading (Common title & details)
        </div>
        <div class="section-body">
            <form action="{{ route('admin.home.banner.store') }}" method="POST" class="section-form" novalidate>
                @csrf
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div class="form-group">
                        <label>Small Title <span style="color: red;">*</span></label>
                        <input type="text" name="small_title" class="form-control" value="{{ old('small_title', $banner->small_title) }}" required>
                        <span class="error-text @error('small_title') d-block server-error @enderror" id="error-small_title">{{ $errors->first('small_title') ?: 'Small Title is required' }}</span>
                    </div>
                    
                    <div class="form-group">
                        <label>Main Title <span style="color: red;">*</span></label>
                        <input type="text" name="main_title" class="form-control" value="{{ old('main_title', $banner->main_title) }}" required>
                        <span class="error-text @error('main_title') d-block server-error @enderror" id="error-main_title">{{ $errors->first('main_title') ?: 'Main Title is required' }}</span>
                    </div>
                </div>

                <div class="form-group">
                    <label>Description <span style="color: red;">*</span></label>
                    <textarea name="description" class="form-control tinymce" rows="3" required>{{ old('description', $banner->description) }}</textarea>
                    <span class="error-text @error('description') d-block server-error @enderror" id="error-description">{{ $errors->first('description') ?: 'Description is required' }}</span>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div class="form-group">
                        <label>Button Text <span style="color: red;">*</span></label>
                        <input type="text" name="button_text" class="form-control" value="{{ old('button_text', $banner->button_text) }}" required>
                        <span class="error-text @error('button_text') d-block server-error @enderror" id="error-button_text">{{ $errors->first('button_text') ?: 'Button Text is required' }}</span>
                    </div>
                    
                    <div class="form-group">
                        <label>Button Link <span style="color: red;">*</span></label>
                        <input type="text" name="button_link" class="form-control" value="{{ old('button_link', $banner->button_link) }}" required>
                        <span class="error-text @error('button_link') d-block server-error @enderror" id="error-button_link">{{ $errors->first('button_link') ?: 'Button Link is required' }}</span>
                    </div>
                </div>

                <hr style="margin: 1.5rem 0; border: 0; border-top: 1px dotted var(--border-color);">

                <div style="display: grid; grid-template-columns: repeat(5, 1fr); gap: 1rem;">
                    <div class="form-group">
                        <label>Trusted Clients Count <span style="color: red;">*</span></label>
                        <input type="text" name="trusted_clients_count" class="form-control" value="{{ old('trusted_clients_count', $banner->trusted_clients_count) }}" required>
                        <span class="error-text @error('trusted_clients_count') d-block server-error @enderror" id="error-trusted_clients_count">Required</span>
                    </div>
                    <div class="form-group">
                        <label>Trusted Clients Label <span style="color: red;">*</span></label>
                        <input type="text" name="trusted_clients_label" class="form-control" value="{{ old('trusted_clients_label', $banner->trusted_clients_label) }}" required>
                        <span class="error-text @error('trusted_clients_label') d-block server-error @enderror" id="error-trusted_clients_label">Required</span>
                    </div>
                    <div class="form-group">
                        <label>Rating Score (0-5) <span style="color: red;">*</span></label>
                        <input type="number" step="0.1" name="google_rating" class="form-control" 
                               value="{{ old('google_rating', $banner->google_rating) }}" 
                               min="0" max="5" 
                               oninput="if(this.value > 5) this.value = 5; if(this.value < 0) this.value = 0;" required>
                        <span class="error-text @error('google_rating') d-block server-error @enderror" id="error-google_rating">Required</span>
                    </div>
                    <div class="form-group">
                        <label>Rating Label <span style="color: red;">*</span></label>
                        <input type="text" name="rating_label" class="form-control" value="{{ old('rating_label', $banner->rating_label) }}" placeholder="e.g. Google Rating" required>
                        <span class="error-text @error('rating_label') d-block server-error @enderror" id="error-rating_label">Required</span>
                    </div>
                    <div class="form-group">
                        <label>Review Label <span style="color: red;">*</span></label>
                        <input type="text" name="review_label" class="form-control" value="{{ old('review_label', $banner->review_label) }}" placeholder="e.g. Based on 500 Reviews" required>
                        <span class="error-text @error('review_label') d-block server-error @enderror" id="error-review_label">Required</span>
                    </div>
                </div>

                <div style="margin-top: 1rem;">
                    <button type="submit" class="btn-update">Update section</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Media Table -->
    <div class="section-container">
        <form action="{{ route('admin.home.media.bulkDelete') }}" method="POST" id="mediaBulkForm">
            @csrf
            @method('DELETE')
            @php $activeMediaCount = $mediaList->where('status', 1)->count(); @endphp
            <div class="section-header" style="background-color: transparent;">
                <div style="display: flex; gap: 1rem; align-items: center;">
                    <button type="button" onclick="submitBulkDelete('mediaBulkForm', '{{ route('admin.home.media.bulkDelete') }}')" class="btn-update" style="color: white; background: #ef4444; border-color: #ef4444;">Delete Selected</button>
                    <button type="button" onclick="submitBulkToggle('mediaBulkForm', '{{ route('admin.home.media.bulkToggleStatus') }}')" class="btn-update" style="color: white; background: #64748b; border-color: #64748b;">Toggle Status</button>
                    <span style="font-size: 0.875rem; color: #64748b; font-weight: 400;">Media items. (Max 3 active allowed)</span>
                </div>
                <div>
                    @if($activeMediaCount >= 3)
                        <span style="color: #ef4444; font-size: 0.85rem; margin-right: 10px; font-weight: 600;">Limit Reached (3 Active Max)</span>
                        <button type="button" class="btn-add" style="opacity: 0.5; cursor: not-allowed;" onclick="alert('You can only have 3 active media items at a time.')">Add Media</button>
                    @else
                        <a href="javascript:void(0)" onclick="openModal('mediaModal')" class="btn-add">Add Media</a>
                    @endif
                </div>
            </div>
            <div>
                <table class="table datatable">
                    <thead>
                        <tr>
                            <th style="width: 40px;"><input type="checkbox" onclick="toggleAll(this, 'media_ids[]')"></th>
                            <th style="width: 60px;">#</th>
                            <th>File / Type</th>
                            <th>Alt Text</th>
                            <th style="width: 100px;">Order</th>
                            <th style="width: 100px;">Status</th>
                            <th style="width: 100px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($mediaList as $index => $media)
                            <tr>
                                <td><input type="checkbox" name="ids[]" value="{{ $media->id }}" class="media_ids[]"></td>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    @if($media->type == 'image')
                                        <img src="{{ Storage::url($media->file_path) }}" alt="{{ $media->alt_text }}" style="height: 40px; border-radius: 4px;">
                                    @else
                                        @if($media->thumbnail_path)
                                            <img src="{{ Storage::url($media->thumbnail_path) }}" alt="Thumbnail" style="height: 40px; border-radius: 4px; margin-right: 5px;">
                                        @endif
                                        <span class="badge" style="background: #e2e8f0; color: #475569;">{{ strtoupper($media->type) }}</span>
                                    @endif
                                </td>
                                <td>{{ $media->alt_text ?: '-' }}</td>
                                <td>
                                    <select class="form-control" style="padding: 0.25rem;" onchange="updatePosition('{{ route('admin.home.media.update', $media->id) }}', this.value)">
                                        @for($i = 1; $i <= max($mediaList->count(), $media->position, 1); $i++)
                                            <option value="{{ $i }}" {{ $media->position == $i ? 'selected' : '' }}>{{ $i }}</option>
                                        @endfor
                                    </select>
                                </td>
                                <td>
                                    <label class="toggle-switch">
                                        <input type="checkbox" onchange="toggleStatus('{{ route('admin.home.media.toggleStatus') }}', {{ $media->id }})" {{ $media->status ? 'checked' : '' }}>
                                        <span class="slider"></span>
                                    </label>
                                </td>
                                <td style="display:flex;">
                                    <button type="button" onclick="openMediaEdit({{ $media->id }}, {{ $media->position }}, '{{ addslashes($media->alt_text) }}', '{{ $media->type }}')" class="action-btn"><i class="fas fa-pencil-alt"></i></button>
                                    <button type="button" onclick="deleteItem('{{ route('admin.home.media.destroy', $media->id) }}')" class="action-btn" style="color: #ef4444;"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align: center; padding: 2rem; color: #64748b;">No media items added yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </form>
    </div>

    <!-- Trusted Clients Table -->
    <div class="section-container">
        <form action="{{ route('admin.home.client.bulkDelete') }}" method="POST" id="clientBulkForm">
            @csrf
            @method('DELETE')
            <div class="section-header" style="background-color: transparent;">
                <div style="display: flex; gap: 1rem; align-items: center;">
                    <button type="button" onclick="submitBulkDelete('clientBulkForm', '{{ route('admin.home.client.bulkDelete') }}')" class="btn-update" style="color: white; background: #ef4444; border-color: #ef4444;">Delete Selected</button>
                    <button type="button" onclick="submitBulkToggle('clientBulkForm', '{{ route('admin.home.client.bulkToggleStatus') }}')" class="btn-update" style="color: white; background: #64748b; border-color: #64748b;">Toggle Status</button>
                    <span style="font-size: 0.875rem; color: #64748b; font-weight: 400;">Trusted Client items.</span>
                </div>
                <div>
                    <a href="javascript:void(0)" onclick="openModal('clientModal')" class="btn-add">Add Client</a>
                </div>
            </div>
            <div>
                <table class="table datatable">
                    <thead>
                        <tr>
                            <th style="width: 40px;"><input type="checkbox" onclick="toggleAll(this, 'client_ids[]')"></th>
                            <th style="width: 60px;">#</th>
                            <th>Client Image</th>
                            <th>Alt Text</th>
                            <th>Client Name</th>
                            <th style="width: 100px;">Order</th>
                            <th style="width: 100px;">Status</th>
                            <th style="width: 100px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($trustedClients as $index => $client)
                            <tr>
                                <td><input type="checkbox" name="ids[]" value="{{ $client->id }}" class="client_ids[]"></td>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <img src="{{ Storage::url($client->client_image) }}" alt="{{ $client->alt_text ?: $client->client_name }}" style="height: 40px; border-radius: 4px;">
                                </td>
                                <td>{{ $client->alt_text ?: '-' }}</td>
                                <td>{{ $client->client_name }}</td>
                                <td>
                                    <select class="form-control" style="padding: 0.25rem;" onchange="updatePosition('{{ route('admin.home.client.update', $client->id) }}', this.value)">
                                        @for($i = 1; $i <= max($trustedClients->count(), $client->position, 1); $i++)
                                            <option value="{{ $i }}" {{ $client->position == $i ? 'selected' : '' }}>{{ $i }}</option>
                                        @endfor
                                    </select>
                                </td>
                                <td>
                                    <label class="toggle-switch">
                                        <input type="checkbox" onchange="toggleStatus('{{ route('admin.home.client.toggleStatus') }}', {{ $client->id }})" {{ $client->status ? 'checked' : '' }}>
                                        <span class="slider"></span>
                                    </label>
                                </td>
                                <td style="display:flex;">
                                    <button type="button" onclick="openClientEdit({{ $client->id }}, '{{ addslashes($client->client_name) }}', {{ $client->position }}, '{{ addslashes($client->alt_text) }}')" class="action-btn"><i class="fas fa-pencil-alt"></i></button>
                                    <button type="button" onclick="deleteItem('{{ route('admin.home.client.destroy', $client->id) }}')" class="action-btn" style="color: #ef4444;"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="text-align: center; padding: 2rem; color: #64748b;">No client items added yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </form>
    </div>

    <!-- Modals -->
    <style>
        .modal-overlay { display: none; position: fixed; top:0; left:0; width:100%; height:100%; background: rgba(0,0,0,0.5); z-index: 1050; align-items:center; justify-content:center; }
        .modal-overlay .modal { display: block !important; background: #fff; width: 500px; max-width: 90%; border-radius: 0.5rem; padding: 1.5rem; box-shadow: 0 4px 6px rgba(0,0,0,0.1); position: static; height: auto; }
        .modal-header { display:flex; justify-content:space-between; align-items:center; margin-bottom: 1.5rem; border-bottom: 1px solid var(--border-color); padding-bottom: 0.5rem;}
        .modal-header h3 { margin: 0; color: #1e293b; }
        .modal-close { background: transparent; border: none; font-size: 1.5rem; cursor: pointer; color: #64748b; }
    </style>

    <!-- Media Modal -->
    <div id="mediaModal" class="modal-overlay">
        <div class="modal">
            <div class="modal-header">
                <h3 id="mediaModalTitle">Add Media</h3>
                <button type="button" class="modal-close" onclick="closeModal('mediaModal')">&times;</button>
            </div>
            <form id="mediaForm" method="POST" action="{{ route('admin.home.media.store') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_method" id="mediaMethod" value="POST">
                <input type="hidden" name="pre_uploaded_path" id="preUploadedPath">
                
                <div class="form-group">
                    <label>File (Image/Video)</label>
                    <input type="file" name="file" class="form-control" id="mediaFileInput" accept="image/*,video/*">
                    <div id="uploadProgress" style="display: none; margin-top: 10px;">
                        <div style="height: 10px; background: #eee; border-radius: 5px; overflow: hidden;">
                            <div id="progressBar" style="height: 100%; background: #4b2382; width: 0%;"></div>
                        </div>
                        <span id="progressPercent" style="font-size: 12px; color: #64748b;">0% uploaded</span>
                        <div id="uploadSuccess" style="font-size: 12px; color: #22c55e; display: none;">Finalizing upload...</div>
                    </div>
                    <small id="mediaFileHelp" style="color: #64748b;"></small>
                </div>

                <div class="form-group">
                    <label>Order / Position</label>
                    <input type="number" min="1" name="position" id="mediaPosition" class="form-control" placeholder="Leave empty to push to last">
                </div>

                <div class="form-group" id="thumbnailGroup" style="display: none;">
                    <label>Thumbnail / Preview Image (For Videos)</label>
                    <input type="file" name="thumbnail" class="form-control" accept="image/*">
                    <small id="thumbnailHelp" style="color: #64748b;">Recommended for videos: 1280x720</small>
                </div>

                <div class="form-group">
                    <label>Alt Text</label>
                    <input type="text" name="alt_text" id="mediaAltText" class="form-control" placeholder="Image alt text or Video description">
                </div>

                <div style="text-align: right;">
                    <button type="button" class="btn-update" style="background:#f1f5f9; color:#475569; border-color:#cbd5e1; margin-right: 0.5rem;" onclick="closeModal('mediaModal')">Cancel</button>
                    <button type="submit" class="btn-add" id="saveMediaBtn">Save Media</button>
                </div>
            </form>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/resumablejs@1.1.0/resumable.min.js"></script>
    <script>
        var resumable = new Resumable({
            target: '{{ route("admin.home.media.chunkUpload") }}',
            query: { _token: '{{ csrf_token() }}' },
            fileType: ['mp4', 'mov', 'avi', 'webm'],
            chunkSize: 5 * 1024 * 1024, // 5MB
            simultaneousUploads: 1,
            testChunks: false,
            throttleProgressCallbacks: 1
        });

        var mediaInput = document.getElementById('mediaFileInput');
        var progressContainer = document.getElementById('uploadProgress');
        var progressBar = document.getElementById('progressBar');
        var progressPercent = document.getElementById('progressPercent');
        var saveBtn = document.getElementById('saveMediaBtn');
        var preUploadedPath = document.getElementById('preUploadedPath');
        var uploadSuccess = document.getElementById('uploadSuccess');

        resumable.assignBrowse(mediaInput);

        resumable.on('fileAdded', function(file) {
            document.getElementById('mediaFileHelp').innerText = 'Selected: ' + file.fileName;
            var ext = file.fileName.split('.').pop().toLowerCase();
            if(['mp4', 'mov', 'avi', 'webm'].includes(ext)) {
                mediaInput.required = false; // Disable required to prevent browser validation "Please select a file"
                document.getElementById('thumbnailGroup').style.display = 'block';
                progressContainer.style.display = 'block';
                saveBtn.disabled = true;
                saveBtn.innerText = 'Uploading Video...';
                resumable.upload();
            } else {
                document.getElementById('thumbnailGroup').style.display = 'none';
                // If it's an image, we still want it to be required if it was required before
            }
        });

        resumable.on('fileProgress', function(file) {
            var progress = Math.floor(file.progress() * 100);
            progressBar.style.width = progress + '%';
            progressPercent.innerText = progress + '% uploaded';
        });

        resumable.on('fileSuccess', function(file, response) {
            var result = JSON.parse(response);
            preUploadedPath.value = result.path;
            uploadSuccess.style.display = 'block';
            progressPercent.innerText = '100% uploaded';
            saveBtn.disabled = false;
            saveBtn.innerText = 'Save Media';
            mediaInput.required = false; // Disable required since we have pre_uploaded_path
        });

        resumable.on('fileError', function(file, response) {
            alert('Video upload failed. Please try again.');
            saveBtn.disabled = false;
            saveBtn.innerText = 'Save Media';
            progressContainer.style.display = 'none';
        });
    </script>

    <!-- Client Modal -->
    <div id="clientModal" class="modal-overlay">
        <div class="modal">
            <div class="modal-header">
                <h3 id="clientModalTitle">Add Client</h3>
                <button type="button" class="modal-close" onclick="closeModal('clientModal')">&times;</button>
            </div>
            <form id="clientForm" method="POST" action="{{ route('admin.home.client.store') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_method" id="clientMethod" value="POST">
                
                <div class="form-group">
                    <label>Client Image</label>
                    <input type="file" name="client_image" class="form-control" id="clientFileInput" accept="image/*">
                    <small id="clientFileHelp" style="color: #64748b;"></small>
                </div>

                <div class="form-group">
                    <label>Client Name</label>
                    <input type="text" name="client_name" id="clientName" class="form-control">
                </div>

                <div class="form-group">
                    <label>Order / Position</label>
                    <input type="number" min="1" name="position" id="clientPosition" class="form-control" placeholder="Leave empty to push to last">
                </div>

                <div class="form-group">
                    <label>Alt Text</label>
                    <input type="text" name="alt_text" id="clientAltText" class="form-control" placeholder="Image alt text">
                </div>

                <div style="text-align: right;">
                    <button type="button" class="btn-update" style="background:#f1f5f9; color:#475569; border-color:#cbd5e1; margin-right: 0.5rem;" onclick="closeModal('clientModal')">Cancel</button>
                    <button type="submit" class="btn-add">Save Client</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Hidden Form for Deletes and Toggles -->
    <form id="actionForm" method="POST" style="display: none;">
        @csrf
        <input type="hidden" name="_method" id="actionMethod" value="DELETE">
        <input type="hidden" name="id" id="actionId">
    </form>

    <!-- Hidden Form for Position Change -->
    <form id="positionForm" method="POST" style="display: none;">
        @csrf
        <input type="hidden" name="_method" value="PUT">
        <input type="hidden" name="position" id="positionInput">
    </form>

    <script>
        // Modal functions
        function openModal(id) {
            document.getElementById(id).style.display = 'flex';
        }
        function closeModal(id) {
            document.getElementById(id).style.display = 'none';
        }

        // Media Edit
        function openMediaEdit(id, position, altText, type) {
            document.getElementById('mediaModalTitle').innerText = 'Edit Media';
            document.getElementById('mediaMethod').value = 'PUT';
            document.getElementById('mediaForm').action = '/admin/home/media/' + id + '/update';
            document.getElementById('mediaFileInput').required = false;
            document.getElementById('mediaFileHelp').innerText = 'Leave blank to keep existing file.';
            document.getElementById('mediaPosition').value = position;
            document.getElementById('mediaAltText').value = altText || '';
            document.getElementById('preUploadedPath').value = '';
            document.getElementById('uploadProgress').style.display = 'none';
            document.getElementById('uploadSuccess').style.display = 'none';
            document.getElementById('progressBar').style.width = '0%';
            document.getElementById('saveMediaBtn').disabled = false;
            document.getElementById('saveMediaBtn').innerText = 'Save Media';
            
            // Show thumbnail group if it's a video
            if (type === 'video') {
                document.getElementById('thumbnailGroup').style.display = 'block';
                document.getElementById('thumbnailHelp').innerText = 'Leave blank to keep existing thumbnail.';
            } else {
                document.getElementById('thumbnailGroup').style.display = 'none';
            }
            
            openModal('mediaModal');
        }

        // Client Edit
        function openClientEdit(id, name, position, altText) {
            document.getElementById('clientModalTitle').innerText = 'Edit Client';
            document.getElementById('clientMethod').value = 'PUT';
            document.getElementById('clientForm').action = '/admin/home/client/' + id + '/update';
            document.getElementById('clientFileInput').required = false;
            document.getElementById('clientFileHelp').innerText = 'Leave blank to keep existing image.';
            document.getElementById('clientName').value = name;
            document.getElementById('clientPosition').value = position;
            document.getElementById('clientAltText').value = altText || '';
            openModal('clientModal');
        }

        // Reset modals when adding new
        document.querySelectorAll('.btn-add').forEach(btn => {
            if(btn.innerText.includes('Add Media')) {
                btn.onclick = function(e) {
                    e.preventDefault();
                    document.getElementById('mediaModalTitle').innerText = 'Add Media';
                    document.getElementById('mediaMethod').value = 'POST';
                    document.getElementById('mediaForm').action = '{{ route("admin.home.media.store") }}';
                    document.getElementById('mediaFileInput').required = true;
                    document.getElementById('mediaFileHelp').innerText = '';
                    document.getElementById('mediaPosition').value = '';
                    document.getElementById('mediaAltText').value = '';
                    document.getElementById('preUploadedPath').value = '';
                    document.getElementById('thumbnailGroup').style.display = 'none';
                    document.getElementById('uploadProgress').style.display = 'none';
                    document.getElementById('uploadSuccess').style.display = 'none';
                    document.getElementById('progressBar').style.width = '0%';
                    document.getElementById('saveMediaBtn').disabled = false;
                    document.getElementById('saveMediaBtn').innerText = 'Save Media';
                    openModal('mediaModal');
                }
            }
            if(btn.innerText.includes('Add Client')) {
                btn.onclick = function(e) {
                    e.preventDefault();
                    document.getElementById('clientModalTitle').innerText = 'Add Client';
                    document.getElementById('clientMethod').value = 'POST';
                    document.getElementById('clientForm').action = '{{ route("admin.home.client.store") }}';
                    document.getElementById('clientFileInput').required = true;
                    document.getElementById('clientFileHelp').innerText = '';
                    document.getElementById('clientName').value = '';
                    document.getElementById('clientPosition').value = '';
                    document.getElementById('clientAltText').value = '';
                    openModal('clientModal');
                }
            }
        });

        // Toggle All Checkboxes
        function toggleAll(source, className) {
            checkboxes = document.getElementsByClassName(className);
            for(var i=0, n=checkboxes.length;i<n;i++) {
                checkboxes[i].checked = source.checked;
            }
        }

        // Submit Bulk Delete Action
        function submitBulkDelete(formId, url) {
            if(confirm('Are you sure you want to delete the selected items?')) {
                let form = document.getElementById(formId);
                form.action = url;
                form.querySelector('input[name="_method"]').value = 'DELETE';
                form.submit();
            }
        }

        // Submit Bulk Toggle Action
        function submitBulkToggle(formId, url) {
            if(confirm('Are you sure you want to toggle the status for the selected items?')) {
                let form = document.getElementById(formId);
                form.action = url;
                form.querySelector('input[name="_method"]').value = 'POST';
                form.submit();
            }
        }

        // Single Toggle Status Switch
        function toggleStatus(url, id) {
            let form = document.getElementById('actionForm');
            form.action = url;
            document.getElementById('actionMethod').value = 'POST';
            document.getElementById('actionId').value = id;
            form.submit();
        }

        // Single Delete
        function deleteItem(url) {
            if(confirm('Are you sure you want to delete this item?')) {
                let form = document.getElementById('actionForm');
                form.action = url;
                document.getElementById('actionMethod').value = 'DELETE';
                form.submit();
            }
        }

        // Single Position Update
        function updatePosition(url, val) {
            let form = document.getElementById('positionForm');
            form.action = url;
            document.getElementById('positionInput').value = val;
            form.submit();
        }
    </script>
</div>
@endsection
