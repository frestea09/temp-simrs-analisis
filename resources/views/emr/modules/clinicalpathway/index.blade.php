@extends('master')

@section('header')
    <h1>Clinical Pathway</h1>
@endsection

@section('content')
<div class="box box-primary">
    <div class="box-header with-border d-flex justify-content-between align-items-center">
        {{-- <h3 class="box-title">Daftar Clinical Pathway</h3> --}}

        @if($parentPath !== null)
            <a href="{{ url('clinicalpathway' . ($parentPath ? '/' . $parentPath : '')) }}" 
              class="btn btn btn-info">
                <i class="fa fa-arrow-left"></i>
            </a>
        @endif
    </div>

    <div class="box-body">

        @if(count($folders) > 0)
            <div class="panel-group" id="accordion">
                @foreach ($folders as $idx => $folder)
                    <div class="panel box box-primary">
                        <div class="box-header with-border">
                            <h4 class="box-title">
                                <a href="{{ url('clinicalpathway/' . ($path ? $path . '/' : '') . $folder) }}">
                                  {{ ucfirst(str_replace('_',' ', $folder)) }}
                                </a>
                            </h4>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        @if(count($files) > 0)
            {{-- <h4 class="mt-3"><strong>Dokumen</strong></h4> --}}
            <div class="row">
                @foreach ($files as $file)
                    <div class="col-md-4 col-sm-6">
                        <div class="card" style="border: 1px solid #ddd; border-radius: 10px; margin-bottom: 15px; background: #f9f9f9;">
                            <div class="card-body text-center p-3">
                                <i class="fa fa-file-pdf-o" style="font-size: 40px; color: #d9534f;"></i>
                                <p style="margin-top: 10px; font-weight: bold;">{{ $file }}</p>
                                <a href="{{ asset('clinical-pathway/' . ($path ? $path . '/' : '') . $file) }}" 
                                   target="_blank" 
                                   class="btn btn btn-success" style="margin-top: 5px;">
                                    Lihat PDF
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        @if(count($folders) === 0 && count($files) === 0)
            <p class="text-muted text-center">Tidak ada folder atau dokumen di sini.</p>
        @endif

    </div>
</div>
@endsection
