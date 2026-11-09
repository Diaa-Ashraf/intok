import { Head, useForm } from '@inertiajs/react';

export default function Login() {
    const { data, setData, post, processing, errors, reset } = useForm({
        email: '',
        password: '',
        remember: false,
    });

    function submit(event) {
        event.preventDefault();
        post('/admin/login', { onFinish: () => reset('password') });
    }

    return (
        <>
            <Head title="دخول الإدارة" />
            <main className="grid min-h-screen place-items-center bg-slate-100 px-4 py-10" dir="rtl">
                <section className="w-full max-w-md rounded-3xl bg-white p-7 shadow-xl sm:p-9">
                    <div className="flex items-center gap-3 mb-3">
                        <div className="size-12 overflow-hidden rounded-full border-2 border-red-600 p-0.5 shadow-xs shrink-0">
                            <img src="/assets/images/intok-logo.jpg" alt="INTOK Logo" className="size-full object-cover rounded-full" />
                        </div>
                        <div>
                            <span className="text-xl font-black text-slate-900 tracking-tight block">INTOK ACADEMY</span>
                            <span className="text-xs font-bold text-red-600">لوحة الإدارة المعتمدة</span>
                        </div>
                    </div>
                    <h1 className="mt-4 text-2xl sm:text-3xl font-black text-slate-900">تسجيل دخول الإدارة</h1>
                    <p className="mt-2 text-slate-500">أدخل بيانات حساب الإدارة للمتابعة.</p>
                    <form onSubmit={submit} className="mt-7 space-y-5">
                        <div>
                            <label htmlFor="email" className="mb-2 block text-sm font-semibold">البريد الإلكتروني</label>
                            <input id="email" type="email" autoComplete="username" required value={data.email} onChange={(event) => setData('email', event.target.value)} className="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-100" />
                            {errors.email && <p role="alert" className="mt-2 text-sm text-red-700">{errors.email}</p>}
                        </div>
                        <div>
                            <label htmlFor="password" className="mb-2 block text-sm font-semibold">كلمة المرور</label>
                            <input id="password" type="password" autoComplete="current-password" required value={data.password} onChange={(event) => setData('password', event.target.value)} className="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-100" />
                            {errors.password && <p role="alert" className="mt-2 text-sm text-red-700">{errors.password}</p>}
                        </div>
                        <label className="flex items-center gap-2 text-sm text-slate-600"><input type="checkbox" checked={data.remember} onChange={(event) => setData('remember', event.target.checked)} className="rounded border-slate-300 text-red-600 focus:ring-red-500" />تذكرني على هذا الجهاز</label>
                        <button disabled={processing} className="w-full rounded-xl bg-red-600 px-5 py-3 font-bold text-white transition hover:bg-red-700 disabled:opacity-60">{processing ? 'جارٍ تسجيل الدخول…' : 'دخول'}</button>
                    </form>
                    <a href="/admin/forgot-password" className="mt-5 inline-flex text-sm font-semibold text-slate-600 hover:text-red-600">نسيت كلمة المرور؟</a>
                </section>
            </main>
        </>
    );
}
