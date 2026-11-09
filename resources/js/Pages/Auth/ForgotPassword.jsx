import { Head, useForm } from '@inertiajs/react';

export default function ForgotPassword({ status }) {
    const form = useForm({ email: '' });
    function submit(event) { event.preventDefault(); form.post('/admin/forgot-password'); }

    return <><Head title="استعادة كلمة المرور" /><main className="grid min-h-screen place-items-center bg-slate-100 px-4 py-10" dir="rtl"><section className="w-full max-w-md rounded-3xl bg-white p-7 shadow-xl sm:p-9"><a href="/admin/login" className="text-sm font-bold text-red-600">INTOK Academy</a><h1 className="mt-4 text-3xl font-black">استعادة كلمة المرور</h1><p className="mt-2 leading-7 text-slate-500">أدخل بريد حساب الإدارة لإرسال رابط إعادة تعيين كلمة المرور.</p>{(status || form.errors.email) && <p role="status" className="mt-5 rounded-xl bg-green-50 p-3 text-sm text-green-800">{status || form.errors.email}</p>}<form onSubmit={submit} className="mt-7 space-y-5"><label htmlFor="email" className="block text-sm font-semibold">البريد الإلكتروني</label><input id="email" type="email" required autoComplete="username" value={form.data.email} onChange={(event) => form.setData('email', event.target.value)} className="w-full rounded-xl border border-slate-300 px-4 py-3" /><button disabled={form.processing} className="w-full rounded-xl bg-red-600 px-5 py-3 font-bold text-white disabled:opacity-60">إرسال رابط الاستعادة</button></form></section></main></>;
}
