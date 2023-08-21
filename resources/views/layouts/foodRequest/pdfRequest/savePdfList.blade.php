@extends('layouts.app')

@section('contentFoodRequest')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Save Pdf List</title>
</head>

<body>
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        @if(session('Error'))
                        <div class="alert alert-danger">{{ session('Error') }}</div>
                        @endif

                        @if(session('Warning'))
                        <div class="alert alert-warning">{{ session('Warning') }}</div>
                        @endif

                        @if(session('Success'))
                        <div class="alert alert-success">{{ session('Success') }}</div>
                        @endif
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('pdfSave.save') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="row mb-3">
                                <label for="pdfFile" class="col-md-4 col-form-label text-md-end">{{ __('Archivo PDF') }}</label>

                                <div class="col-md-6">
                                    <input id="pdfFile" type="file" class="form-control @error('file') is-invalid @enderror" name="file" value="{{ old('file') }}" required autocomplete="file" autofocus>

                                    @error('pdfFile')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="comments" class="col-md-4 col-form-label text-md-end">{{ __('Comentarios') }}</label>

                                <div class="col-md-6">
                                    <input id="comments" type="text" class="form-control @error('comments') is-invalid @enderror" name="comments" value="{{ old('comments') }}" required autocomplete="comments" autofocus>

                                    @error('comments')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="category" class="col-md-4 col-form-label text-md-end">{{ __('Categoria') }}</label>

                                <div class="col-md-6">
                                    <select id="category" class="form-select @error('category') is-invalid @enderror" name="category" value="{{ old('category') }}" required autocomplete="category">
                                        <option value="Abarrotes">Abarrotes</option>
                                        <option value="Frutas-Verduras">Frutas y Verduras</option>
                                        <option value="Papeleria">Papeleria</option>
                                        <option value="Limpieza">Limpieza</option>
                                        <option value="Carnes-Lacteos">Carnes y Lacteos</option>
                                        <option value="Granos-Legumbres">Granos y Legumbres</option>
                                        <option value="Medicinas">Medicinas</option>
                                    </select>

                                    @error('category')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-success">Enviar Archivo PDF</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
@endsection