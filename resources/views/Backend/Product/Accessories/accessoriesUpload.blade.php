@extends('Backend.dashboard.layout')

@section('content')
<x-breadcrumbs breadcrumb="accessories.create" />

<div class="container">
    <h2>Import Accessories from Excel File</h2>

    <!-- Link to Download Excel Template -->
    <div class="mb-3">
        <a href="{{ route('accessories.template') }}" class="btn btn-secondary" download>
            Download Excel Template
        </a>
    </div>

    <!-- Form to Upload Excel File -->
    <form action="{{ route('accessories.import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="file">Choose Excel File</label>
            <input type="file" class="form-control" id="file" name="file" required>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Upload and Import Accessories</button>
    </form>

    <!-- Instructions Section -->
    <div class="alert alert-info mt-3">
        <p><strong>Instructions:</strong></p>
        <ul>
            <li>1. Download the Excel template by clicking the <strong>"Download Excel Template"</strong> button.</li>
            <li>2. Fill in the accessory information in the Excel file according to the given format.</li>
            <li>3. Choose the completed Excel file and click <strong>"Upload and Import Accessories"</strong>.</li>
        </ul>
    </div>
</div>
@endsection
