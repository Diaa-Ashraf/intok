<h1>طلب جديد من موقع INTOK</h1>
<p>نوع الطلب: {{ $type }}</p>
@foreach ($details as $label => $value)
    <p><strong>{{ $label }}:</strong> {{ $value }}</p>
@endforeach
