@include('CRM.header')
@include('CRM.sidebar')
<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        @include('CRM.headerCrm')
<form action="{{ route('CRM.ajoutImages') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="image" required>
    <input type="file" name="pdf" required>
    <button type="submit">Enregistrer l'image</button>
</form>
    </div>
</div>
@include('CRM.footer')
