@if($errors->any())
    <div style="background-color: #fee2e2; color: #991b1b; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
        @foreach($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
@endif

<form action="{{ $action }}" method="POST">
    @csrf
    @if($method !== 'POST')
        @method($method)
    @endif
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1rem; align-items: end;">
        <div class="form-group" style="margin: 0;">
            <label>Old URL <span style="color: red;">*</span></label>
            <input type="text" name="from_path" class="form-control" placeholder="/old-page"
                   value="{{ old('from_path', $redirect->from_path ?? $prefillFrom ?? '') }}" required>
        </div>
        <div class="form-group" style="margin: 0;">
            <label>Redirect To <span style="color: red;">*</span></label>
            <input type="text" name="to_url" class="form-control" placeholder="/new-page or https://..."
                   value="{{ old('to_url', $redirect->to_url ?? '') }}" required>
        </div>
        <div class="form-group" style="margin: 0;">
            <label>Type</label>
            @php $code = (int) old('status_code', $redirect->status_code ?? 301); @endphp
            <select name="status_code" class="form-control">
                <option value="301" {{ $code === 301 ? 'selected' : '' }}>301 – Permanent</option>
                <option value="302" {{ $code === 302 ? 'selected' : '' }}>302 – Temporary</option>
            </select>
        </div>
        <div>
            <button type="submit" class="btn-submit" style="width: 100%;">{{ $submitLabel }}</button>
        </div>
    </div>
</form>
