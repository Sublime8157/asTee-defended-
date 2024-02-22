{{-- This extends or use the header file in components folder  --}}

{{-- The @section inherit the @yield in components.header with a string of docu that change it to Dashboard --}}
@section('docu', 'Dashboard')
{{-- Similar function here  --}}
@section('page','DASHBOARD')
<x-header />
<x-nav />
        <div>
            
        </div>
    </div>
</div>
<x-scripts />