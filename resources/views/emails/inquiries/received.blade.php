<h1>استفسار جديد من موقع INTOK</h1>
<p><strong>الاسم:</strong> {{ $inquiry->name }}</p>
<p><strong>البريد:</strong> {{ $inquiry->email ?? '—' }}</p>
<p><strong>الهاتف:</strong> {{ $inquiry->phone ?? '—' }}</p>
<p><strong>الموضوع:</strong> {{ $inquiry->subject ?? '—' }}</p>
<p><strong>الرسالة:</strong></p>
<p style="white-space: pre-line">{{ $inquiry->message }}</p>
