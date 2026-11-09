import { Head } from '@inertiajs/react';
import 'bootstrap';
import { useEffect, useState } from 'react';
import '../../../css/admin.scss';

const adminNavigation = [
    { label: 'الرئيسية', href: '/admin', icon: 'ti-home' },
    { label: 'الاستفسارات', href: '/admin/inquiries', icon: 'ti-message-circle', key: 'newInquiries' },
    { label: 'حجوزات الاستشارات', href: '/admin/bookings', icon: 'ti-calendar-event', key: 'newBookings' },
    { label: 'تسجيلات العملاء', href: '/admin/registrations', icon: 'ti-user-plus', key: 'newRegistrations' },
    { label: 'الخدمات', href: '/admin/services', icon: 'ti-school', adminOnly: true },
    { label: 'الفريق', href: '/admin/team', icon: 'ti-users', adminOnly: true },
    { label: 'الصفحات', href: '/admin/pages', icon: 'ti-file-text', adminOnly: true },
    { label: 'قصص النجاح', href: '/admin/testimonials', icon: 'ti-star', adminOnly: true },
    { label: 'المشرفين والمديرين', href: '/admin/moderators', icon: 'ti-shield-lock', adminOnly: true },
    { label: 'إعدادات الموقع', href: '/admin/settings', icon: 'ti-settings', adminOnly: true },
];

export default function Dashboard({ stats, userName, canManageContent }) {
    const [inquiryCount, setInquiryCount] = useState(stats.newInquiries);
    const [bookingCount, setBookingCount] = useState(stats.newBookings);
    const [registrationCount, setRegistrationCount] = useState(stats.newRegistrations);
    const [latest, setLatest] = useState([]);
    const [sidebarCollapsed, setSidebarCollapsed] = useState(false);
    const [mobileSidebarOpen, setMobileSidebarOpen] = useState(false);
    const [notificationsOpen, setNotificationsOpen] = useState(false);

    useEffect(() => {
        if (!window.Echo) return undefined;

        const channel = window.Echo.private('admin.notifications');
        channel.listen('.inquiry.received', (inquiry) => {
            setInquiryCount((count) => count + 1);
            setLatest((items) => [inquiry, ...items].slice(0, 6));
        });
        channel.listen('.lead.received', (lead) => {
            if (lead.type === 'booking') setBookingCount((count) => count + 1);
            if (lead.type === 'registration') setRegistrationCount((count) => count + 1);
            setLatest((items) => [lead, ...items].slice(0, 6));
        });

        return () => window.Echo.leave('admin.notifications');
    }, []);

    const cards = [
        { label: 'استفسارات جديدة', value: inquiryCount, href: '/admin/inquiries', icon: 'ti-message-circle', tone: 'danger' },
        { label: 'حجوزات الاستشارات', value: bookingCount, href: '/admin/bookings', icon: 'ti-calendar-event', tone: 'warning' },
        { label: 'تسجيلات العملاء', value: registrationCount, href: '/admin/registrations', icon: 'ti-user-plus', tone: 'info' },
        ...(canManageContent ? [
            { label: 'الخدمات المنشورة', value: stats.services, href: '/admin/services', icon: 'ti-school', tone: 'primary' },
            { label: 'أعضاء الفريق', value: stats.teamMembers, href: '/admin/team', icon: 'ti-users', tone: 'success' },
            { label: 'المشرفين والمديرين', value: stats.moderators ?? 1, href: '/admin/moderators', icon: 'ti-shield-lock', tone: 'danger' },
        ] : []),
    ];

    return (
        <>
            <Head title="لوحة الإدارة" />
            <div className="admin-dashboard" dir="rtl">
                <button
                    className={`overlay ${mobileSidebarOpen ? 'show' : ''}`}
                    type="button"
                    aria-label="إغلاق القائمة"
                    onClick={() => setMobileSidebarOpen(false)}
                />

                <nav className={`navbar bg-white border-bottom fixed-top topbar px-3 ${sidebarCollapsed ? 'full' : ''}`} aria-label="شريط الإدارة">
                    <button className="btn btn-light btn-icon btn-sm d-none d-lg-inline-flex" type="button" aria-label="طي القائمة" onClick={() => setSidebarCollapsed((value) => !value)}>
                        <i className="ti ti-layout-sidebar-left-expand" />
                    </button>
                    <button className="btn btn-light btn-icon btn-sm d-lg-none ms-2" type="button" aria-label="فتح القائمة" onClick={() => setMobileSidebarOpen(true)}>
                        <i className="ti ti-menu-2" />
                    </button>
                    <button
                        className="btn btn-light btn-sm d-inline-flex align-items-center gap-1.5 ms-2 rounded-pill px-3 py-1 border shadow-xs"
                        type="button"
                        aria-label="الرجوع للخلف"
                        title="الرجوع للصفحة السابقة"
                        onClick={() => {
                            if (window.history.length > 1) {
                                window.history.back();
                            } else {
                                window.location.href = '/ar';
                            }
                        }}
                    >
                        <i className="ti ti-arrow-right" />
                        <span className="small fw-bold">رجوع</span>
                    </button>
                    <div className="me-auto d-flex align-items-center gap-2">
                        <div className="position-relative">
                            <button className="btn btn-light btn-icon btn-sm rounded-circle position-relative" type="button" aria-label="التنبيهات" aria-expanded={notificationsOpen} onClick={() => setNotificationsOpen((value) => !value)}>
                                <i className="ti ti-bell" />
                                {inquiryCount > 0 && <span className="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">{inquiryCount}</span>}
                            </button>
                            {notificationsOpen && (
                                <div className="dropdown-menu dropdown-menu-end dropdown-menu-md p-0 show" style={{ position: 'absolute', inset: '0 auto auto 0', transform: 'translateY(42px)' }}>
                                    <div className="border-bottom px-3 py-3"><strong>التنبيهات</strong><div className="small text-secondary">استفسارات تصل مباشرة</div></div>
                                    <div className="notification-list">
                                        {latest.length === 0 ? <p className="p-3 mb-0 small text-secondary">لا توجد تنبيهات جديدة في هذه الجلسة.</p> : latest.map((item) => <div key={item.id} className="border-bottom px-3 py-3"><strong className="small">استفسار من {item.name}</strong><div className="small text-secondary">{item.subject || 'بدون موضوع'}</div></div>)}
                                    </div>
                                    <a href="/admin/inquiries" className="d-block text-center px-3 py-3 small">عرض كل الاستفسارات</a>
                                </div>
                            )}
                        </div>
                        <div className="dropdown">
                            <button className="btn btn-light btn-sm rounded-pill d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <span className="avatar avatar-sm rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center">{userName?.slice(0, 1) || 'م'}</span>
                                <span className="d-none d-sm-inline">{userName}</span>
                                <i className="ti ti-chevron-down" />
                            </button>
                            <div className="dropdown-menu dropdown-menu-end p-2">
                                <a href="/admin/profile" className="dropdown-item rounded-2"><i className="ti ti-user ms-2" />الملف الشخصي</a>
                                <form method="POST" action="/admin/logout">{window.document.querySelector('meta[name="csrf-token"]') && <input type="hidden" name="_token" value={window.document.querySelector('meta[name="csrf-token"]').content} />}<button className="dropdown-item rounded-2 text-danger" type="submit"><i className="ti ti-logout ms-2" />تسجيل الخروج</button></form>
                            </div>
                        </div>
                    </div>
                </nav>

                <aside id="sidebar" className={`sidebar ${sidebarCollapsed ? 'collapsed' : ''} ${mobileSidebarOpen ? 'mobile-show' : ''}`} aria-label="القائمة الرئيسية">
                    <div className="logo-area d-flex align-items-center justify-content-between px-3">
                        <a href="/admin" className="d-inline-flex align-items-center gap-2 text-decoration-none">
                            <img src="/assets/images/intok-logo.jpg" alt="INTOK Logo" width="34" height="34" className="rounded-circle border border-danger-subtle flex-shrink-0" style={{ objectFit: 'cover', width: '34px', height: '34px' }} onError={(e) => { e.currentTarget.style.display = 'none'; }} />
                            <span className="logo-text fw-bold text-dark">INTOK ACADEMY</span>
                        </a>
                        <button className="btn btn-sm btn-icon btn-light d-lg-none" type="button" aria-label="إغلاق" onClick={() => setMobileSidebarOpen(false)}>
                            <i className="ti ti-x" />
                        </button>
                    </div>
                    <div className="nav-section">القائمة الرئيسية</div>
                    <ul className="nav flex-column">
                        {adminNavigation.filter((item) => !item.adminOnly || canManageContent).map((item) => (
                            <li key={item.href}>
                                <a className={`nav-link ${item.href === '/admin' ? 'active' : ''}`} href={item.href} onClick={() => setMobileSidebarOpen(false)}>
                                    <i className={`ti ${item.icon}`} /><span className="nav-text">{item.label}</span>
                                    {item.key && stats[item.key] > 0 && <span className="badge bg-danger rounded-pill me-auto">{stats[item.key]}</span>}
                                </a>
                            </li>
                        ))}
                    </ul>
                    <div className="nav-section">الحساب</div>
                    <ul className="nav flex-column">
                        <li><a className="nav-link" href="/admin/profile" onClick={() => setMobileSidebarOpen(false)}><i className="ti ti-user-cog" /><span className="nav-text">الملف الشخصي</span></a></li>
                        <li><a className="nav-link" href="/ar" onClick={() => setMobileSidebarOpen(false)}><i className="ti ti-world" /><span className="nav-text">عرض الموقع</span></a></li>
                    </ul>
                </aside>

                <main id="content" className={`content py-4 px-3 px-lg-5 ${sidebarCollapsed ? 'full' : ''}`}>
                    <div className="container-fluid">
                        <header className="d-flex flex-wrap justify-content-between align-items-end gap-3 mb-4">
                            <div><p className="text-primary fw-semibold mb-1">INTOK Academy</p><h1 className="h3 fw-bold mb-1">لوحة الإدارة</h1><p className="text-secondary mb-0">أهلًا {userName}، هذه نظرة سريعة على الموقع.</p></div>
                            <div className="d-flex align-items-center gap-2">
                                <button
                                    type="button"
                                    onClick={() => {
                                        if (window.history.length > 1) {
                                            window.history.back();
                                        } else {
                                            window.location.href = '/ar';
                                        }
                                    }}
                                    className="btn btn-outline-secondary rounded-3 d-inline-flex align-items-center gap-1.5"
                                    title="الرجوع للصفحة السابقة"
                                >
                                    <i className="ti ti-arrow-right" />
                                    <span>رجوع</span>
                                </button>
                                {canManageContent && <a href="/admin/settings" className="btn btn-outline-secondary rounded-3"><i className="ti ti-settings ms-1" />إعدادات الموقع</a>}
                            </div>
                        </header>

                        <section className="row g-3 g-xl-4" aria-label="إحصاءات الموقع">
                            {cards.map((card) => <div className="col-12 col-sm-6 col-xl-4" key={card.label}><a href={card.href} className="card border-0 shadow-sm h-100 text-decoration-none"><div className="card-body p-4 d-flex justify-content-between align-items-center"><div><div className="text-secondary mb-2">{card.label}</div><div className="h2 fw-bold text-dark mb-0">{card.value}</div></div><span className={`avatar avatar-lg rounded-3 bg-${card.tone}-subtle text-${card.tone} d-flex align-items-center justify-content-center`}><i className={`ti ${card.icon} fs-3`} /></span></div></a></div>)}
                        </section>

                        <section className="card border-0 shadow-sm mt-4">
                            <div className="card-header bg-white border-0 px-4 pt-4 pb-0 d-flex flex-wrap align-items-center justify-content-between gap-3">
                                <div><h2 className="h5 fw-bold mb-1">التنبيهات الفورية</h2><p className="text-secondary small mb-0">الاستفسارات الجديدة تظهر هنا فور وصولها.</p></div>
                                <a href="/admin/inquiries" className="btn btn-sm btn-outline-primary rounded-pill">فتح الاستفسارات</a>
                            </div>
                            <div className="card-body p-4">
                                {latest.length === 0 ? <div className="rounded-3 bg-light p-4 text-secondary">لا توجد تنبيهات جديدة في هذه الجلسة.</div> : <div className="list-group list-group-flush">{latest.map((item) => <article key={item.id} className="list-group-item px-0 py-3 d-flex gap-3"><span className="avatar avatar-sm rounded-circle bg-danger-subtle text-danger d-flex align-items-center justify-content-center"><i className="ti ti-message-circle" /></span><div><h3 className="h6 fw-semibold mb-1">{item.type ? `${item.subject} — ${item.name}` : `استفسار جديد من ${item.name}`}</h3><p className="text-secondary mb-1">{item.subject || 'بدون موضوع'}</p><time className="small text-secondary">{item.created_at ? new Date(item.created_at).toLocaleString('ar-EG') : ''}</time></div></article>)}</div>}
                            </div>
                        </section>
                    </div>
                </main>
            </div>
        </>
    );
}
