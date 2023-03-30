<div class="form-group row">
    <div class="col-sm-12">
        <label>Template Name</label>
        <input type="text" name="name" class="form-control" value="{{old('name', $template->name)}}" placeholder="Enter template name">
        @error('name') <span class="text-danger"> {{ $message }}</span> @enderror
    </div>
</div>
<div class="py-3">
    <strong>Parameters:</strong>
    @foreach($template->parameters as $key => $value)
        <div>
            <code class="bg-light-primary rounded px-1">{{ $key }}</code> : {{ $value }}
        </div>
    @endforeach
</div>
<div class="form-group row">
    <div class="col-sm-12">
        <label>Email Subject</label>
        <input type="text" name="subject" class="form-control" value="{{old('subject', $template->subject)}}" placeholder="Enter email subject">
        @error('subject') <span class="text-danger"> {{ $message }}</span> @enderror
    </div>
</div>
<div class="form-group row">
    <div class="col-sm-12">
        <label>Email Body</label>
        <textarea id="summernoteEditor" name="body">{!! old('body', $template->body) !!}</textarea>
        @if ($errors->has('body')) <span class="text-danger"> {{ $errors->first('body') }}</span> @endif
    </div>
</div>
