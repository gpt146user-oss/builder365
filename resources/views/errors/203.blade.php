@extends('errors.layout')

@section('title', '203 - Non-Authoritative Information')

@section('glow-color-1', '#10B981')
@section('glow-color-2', '#06B6D4')

@section('code-gradient', 'linear-gradient(135deg, #34D399 0%, #22D3EE 100%)')
@section('icon-bg', 'rgba(16, 185, 129, 0.15)')
@section('icon-border', 'rgba(16, 185, 129, 0.3)')
@section('icon-color', '#34D399')
@section('btn-bg', 'linear-gradient(135deg, #059669 0%, #0891B2 100%)')

@section('icon')
    <i class="fa-solid fa-circle-nodes"></i>
@endsection

@section('code', '203')
@section('headline', 'Non-Authoritative Information')
@section('message', 'The request was executed successfully, but the returned information was gathered from a cached copy or third-party proxy rather than the primary origin server.')

@section('actions')
    <button type="button" class="btn-primary" onclick="window.location.reload()">
        <i class="fa-solid fa-sync"></i> Refresh Source Data
    </button>
    <a href="{{ url('/') }}" class="btn-secondary">
        <i class="fa-solid fa-house"></i> Return to Dashboard
    </a>
@endsection
