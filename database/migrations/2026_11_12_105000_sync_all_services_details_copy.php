<?php

use App\Models\Service;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Cache;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $servicesData = [
            // 01. خدمة الترجمة المعتمدة
            [
                'slug_ar' => 'certified-translation',
                'slug_en' => 'certified-translation',
                'slug_it' => 'traduzione-giurata',
                'title' => [
                    'ar' => 'خدمة الترجمة المعتمدة',
                    'en' => 'Certified Translation Service',
                    'it' => 'Servizio di Traduzione Asseverata',
                ],
                'headline' => [
                    'ar' => 'ترجمة معتمدة وموثوقة لجميع مستنداتك',
                    'en' => 'Certified & Trusted Translation for All Your Documents',
                    'it' => 'Traduzione Asseverata e Affidabile per Tutti i Tuoi Documenti',
                ],
                'summary' => [
                    'ar' => 'بنقدم خدمات ترجمة معتمدة للمستندات والوثائق بمختلف أنواعها، مع مراعاة الدقة اللغوية وصحة البيانات والتنسيق المناسب للجهة المقدَّم إليها المستند.',
                    'en' => 'We offer certified translation for documents and official files of all types, ensuring linguistic precision, data validity, and proper formatting for receiving authorities.',
                    'it' => 'Offriamo servizi di traduzione giurata per documenti e atti di ogni tipo, curando accuratezza linguistica, validità dei dati e formato conforme all\'ente ricevente.',
                ],
                'description' => [
                    'ar' => 'بنقدم خدمات ترجمة معتمدة للمستندات والوثائق بمختلف أنواعها، مع مراعاة الدقة اللغوية وصحة البيانات والتنسيق المناسب للجهة المقدَّم إليها المستند.',
                    'en' => 'We offer certified translation for documents and official files of all types, ensuring linguistic precision, data validity, and proper formatting for receiving authorities.',
                    'it' => 'Offriamo servizi di traduzione giurata per documenti e atti di ogni tipo, curando accuratezza linguistica, validità dei dati e formato conforme all\'ente ricevente.',
                ],
                'features' => [
                    'ar' => [
                        'ترجمة مستندات رسمية وأكاديمية وشخصية.',
                        'مراجعة دقيقة للأسماء والتواريخ والبيانات.',
                        'ترجمة من وإلى عدة لغات.',
                        'الالتزام بمتطلبات الجهة المستقبلة حسب نوع المستند.',
                        'إمكانية طلب مراجعة وتدقيق الترجمة.',
                    ],
                    'en' => [
                        'Official, academic, and personal document translation.',
                        'Meticulous verification of names, dates, and vital data.',
                        'Translation across multiple global languages.',
                        'Full compliance with receiving authority guidelines.',
                        'Option to request additional proofreading and editing.',
                    ],
                    'it' => [
                        'Traduzione di documenti ufficiali, accademici e personali.',
                        'Verifica meticolosa di nomi, date e dati essenziali.',
                        'Traduzione da e verso molteplici lingue.',
                        'Conformità ai requisiti dell\'ente ricevente.',
                        'Possibilità di richiedere revisione e asseverazione.',
                    ],
                ],
                'requirements' => [
                    'ar' => [
                        'صورة واضحة من المستند الأصلي.',
                        'تحديد اللغة المطلوبة للترجمة.',
                        'تحديد الجهة التي سيُقدم إليها المستند.',
                        'توضيح الموعد المطلوب للاستلام.',
                    ],
                    'en' => [
                        'Clear copy of the original document.',
                        'Target language specification.',
                        'Receiving authority / institution specification.',
                        'Required delivery deadline.',
                    ],
                    'it' => [
                        'Copia nitida del documento originale.',
                        'Indicazione della lingua di arrivo.',
                        'Indicazione dell\'ente a cui presentare il documento.',
                        'Data di consegna desiderata.',
                    ],
                ],
                'steps' => [
                    'ar' => [
                        'إرسال المستندات وتحديد اللغة.',
                        'مراجعة المستند وتحديد التكلفة والمدة.',
                        'تنفيذ الترجمة والمراجعة.',
                        'تسليم النسخة النهائية.',
                    ],
                    'en' => [
                        'Submit documents and specify target language.',
                        'Document review, quote, and delivery timeline confirmation.',
                        'Professional translation and quality review.',
                        'Delivery of finalized certified copies.',
                    ],
                    'it' => [
                        'Invio dei documenti e scelta della lingua.',
                        'Esame del documento, preventivo e tempi di consegna.',
                        'Esecuzione della traduzione e revisione.',
                        'Consegna della versione finale certificata.',
                    ],
                ],
                'faqs' => [
                    'ar' => [
                        ['question' => 'هل الترجمة معتمدة؟', 'answer' => 'نعم، جميع ترجماتنا معتمدة وموثقة ومطابقة للمعايير الرسمية المعترف بها لدى السفارات والقنصليات والجامعات والجهات الحكومية والخاصة.'],
                        ['question' => 'ما اللغات المتاحة؟', 'answer' => 'نوفر الترجمة المعتمدة لمجموعة واسعة من اللغات تشمل الإيطالية، الإنجليزية، الألمانية، الفرنسية، الإسبانية، وغيرها من اللغات الدولية.'],
                        ['question' => 'هل يمكن ترجمة المستندات الرسمية؟', 'answer' => 'نعم، نترجم كافة المستندات الرسمية مثل شهادات الميلاد والتخرج، كشوف الدرجات، عقود الزواج، السجلات الجنائية، والسجلات التجارية.'],
                        ['question' => 'ما مدة تنفيذ الترجمة؟', 'answer' => 'مدة التنفيذ تعتمد على حجم ونوع المستند، ونوفر خدمة التسليم الفوري والعاجل حسب رغبة واحتياج العميل.'],
                        ['question' => 'هل يمكن استلام الترجمة إلكترونيًا؟', 'answer' => 'نعم، يمكنك استلام نسخة إلكترونية مصدقة بصيغة PDF فور اكتمال الترجمة، بالإضافة إلى إمكانية استلام النسخ الورقية المطبوعة والمختومة.'],
                    ],
                    'en' => [
                        ['question' => 'Is the translation officially certified?', 'answer' => 'Yes, our translations are certified, stamped, and recognized by embassies, consulates, universities, and official government authorities.'],
                        ['question' => 'Which languages are supported?', 'answer' => 'We cover major languages including Italian, English, German, French, Spanish, and many more.'],
                        ['question' => 'Can official personal documents be translated?', 'answer' => 'Yes, we translate birth certificates, graduation degrees, transcripts, marriage certificates, and legal records.'],
                        ['question' => 'How long does the translation take?', 'answer' => 'Turnaround depends on file length; express same-day delivery is available upon request.'],
                        ['question' => 'Can I receive the translation digitally?', 'answer' => 'Yes, verified digital PDF copies are delivered immediately, alongside optional printed and sealed originals.'],
                    ],
                    'it' => [
                        ['question' => 'La traduzione è asseverata ufficialmente?', 'answer' => 'Sì, tutte le traduzioni sono certificate e conformi alle norme richieste da ambasciate, consolati e atenei.'],
                        ['question' => 'Quali lingue sono disponibili?', 'answer' => 'Offriamo traduzioni in italiano, inglese, tedesco, francese, spagnolo e altre lingue europee.'],
                        ['question' => 'È possibile tradurre documenti ufficiali?', 'answer' => 'Certamente, traduciamo certificati di nascita, titoli di studio, casellari giudiziali e atti societari.'],
                        ['question' => 'Quanto tempo richiede la traduzione?', 'answer' => 'I tempi variano in base alla complessità; è disponibile il servizio urgente con consegna rapida.'],
                        ['question' => 'Posso ricevere la traduzione in formato elettronico?', 'answer' => 'Sì, rilasciamo una copia digitale autenticata in PDF oltre ai documenti cartacei asseverati.'],
                    ],
                ],
                'badge' => ['ar' => 'ترجمة رسمية معتمدة', 'en' => 'Certified Translation', 'it' => 'Traduzione Ufficiale'],
                'category_label' => ['ar' => 'الترجمة والاعتماد', 'en' => 'Translation & Certification', 'it' => 'Traduzione & Asseverazione'],
            ],

            // 02. دورات وكورسات اللغات
            [
                'slug_ar' => 'language-courses',
                'slug_en' => 'language-courses',
                'slug_it' => 'corsi-di-lingua',
                'title' => [
                    'ar' => 'دورات وكورسات اللغات',
                    'en' => 'Language Courses & Programs',
                    'it' => 'Corsi e Programmi Linguistici',
                ],
                'headline' => [
                    'ar' => 'اتعلم لغة جديدة وافتح لنفسك فرص أكتر',
                    'en' => 'Learn a New Language & Unlock More Opportunities',
                    'it' => 'Impara una Nuova Lingua e Apri Più Opportunità',
                ],
                'summary' => [
                    'ar' => 'برامج تعليمية لتطوير مهاراتك في اللغات الأجنبية، من المستوى المبتدئ وحتى المتقدم، من خلال تدريب عملي يساعدك تستخدم اللغة في الدراسة والعمل والحياة اليومية.',
                    'en' => 'Educational programs to build foreign language proficiency from beginner to advanced levels, through practical training for study, work, and everyday life.',
                    'it' => 'Programmi didattici per sviluppare competenze nelle lingue straniere, dal livello base all\'avanzato, con pratica attiva per studio e lavoro.',
                ],
                'description' => [
                    'ar' => 'برامج تعليمية لتطوير مهاراتك في اللغات الأجنبية، من المستوى المبتدئ وحتى المتقدم، من خلال تدريب عملي يساعدك تستخدم اللغة في الدراسة والعمل والحياة اليومية.',
                    'en' => 'Educational programs to build foreign language proficiency from beginner to advanced levels, through practical training for study, work, and everyday life.',
                    'it' => 'Programmi didattici per sviluppare competenze nelle lingue straniere, dal livello base all\'avanzato, con pratica attiva per studio e lavoro.',
                ],
                'features' => [
                    'ar' => [
                        'كورسات لمستويات مختلفة.',
                        'تحديد المستوى قبل بدء الدراسة.',
                        'تدريب على المحادثة والاستماع والقراءة والكتابة.',
                        'تطبيقات عملية ومتابعة مستمرة.',
                        'مجموعات تعليمية مناسبة للمستوى.',
                        'لغات متعددة حسب البرامج المتاحة.',
                    ],
                    'en' => [
                        'Courses structured across all proficiency levels (A1 to C2).',
                        'Comprehensive placement test prior to enrollment.',
                        'Intensive training in Speaking, Listening, Reading, and Writing.',
                        'Real-world practice and continuous progress tracking.',
                        'Small group learning tailored to skill level.',
                        'Multiple language offerings based on demand.',
                    ],
                    'it' => [
                        'Corsi strutturati per vari livelli (da A1 a C2).',
                        'Test di livello preliminare personalizzato.',
                        'Allenamento sulle 4 abilità: conversazione, ascolto, lettura e scrittura.',
                        'Esercitazioni pratiche e monitoraggio costante.',
                        'Gruppi di studio omogenei e mirati.',
                        'Diverse lingue europee disponibili.',
                    ],
                ],
                'requirements' => [
                    'ar' => [
                        'تحديد اللغة المراد تعلمها.',
                        'تحديد المستوى الحالي إن وجد.',
                        'الالتزام بحضور المحاضرات والتدريبات.',
                    ],
                    'en' => [
                        'Select target language.',
                        'Assess current skill level (if any).',
                        'Commitment to scheduled classes and practical drills.',
                    ],
                    'it' => [
                        'Scelta della lingua da studiare.',
                        'Indicazione del livello di partenza.',
                        'Impegno nella frequenza delle lezioni e delle esercitazioni.',
                    ],
                ],
                'steps' => [
                    'ar' => [
                        'اختيار اللغة المناسبة.',
                        'تحديد المستوى.',
                        'اختيار المجموعة والجدول.',
                        'بدء الدراسة والتقييم المستمر.',
                    ],
                    'en' => [
                        'Choose the desired language.',
                        'Undergo placement assessment.',
                        'Select preferred schedule and group.',
                        'Begin learning with ongoing evaluations.',
                    ],
                    'it' => [
                        'Scelta della lingua appropriata.',
                        'Valutazione del livello iniziale.',
                        'Scelta del gruppo e dell\'orario.',
                        'Inizio del corso con valutazioni continue.',
                    ],
                ],
                'faqs' => [
                    'ar' => [
                        ['question' => 'هل يمكن البدء من الصفر؟', 'answer' => 'نعم بكل تأكيد، برامجنا مصممة لتبدأ معك من الصفر (المستوى A1) حتى مستويات الإتقان والطلاقة المتقدمة.'],
                        ['question' => 'هل يوجد اختبار تحديد مستوى؟', 'answer' => 'نعم، يخضع المتدرب لاختبار تحديد مستوى دقيق وشامل لتحديد نقطة البداية الأنسب لقدراته.'],
                        ['question' => 'هل الكورسات أونلاين أم حضوري؟', 'answer' => 'نوفر كلا الخيارين: محاضرات حضورية في قاعاتنا المجهزة بالأكاديمية، ومحاضرات تفاعلية عبر الإنترنت (أونلاين) بأعلى جودة.'],
                        ['question' => 'هل أحصل على شهادة بعد انتهاء الكورس؟', 'answer' => 'نعم، يحصل المتدرب على شهادة إتمام معتمدة من INTOK Academy موثقة ومبين بها المستوى وساعات التدريب بعد اجتياز التقييم.'],
                        ['question' => 'ما مدة كل مستوى؟', 'answer' => 'تختلف مدة المستوى حسب وتيرة الكورس (مكثف أو عادي)، وتتراوح عادة بين 4 إلى 8 أسابيع لكل مستوى تعليمي.'],
                    ],
                    'en' => [
                        ['question' => 'Can I start from absolute zero?', 'answer' => 'Yes, our programs start from complete beginner level (A1) all the way to advanced fluency.'],
                        ['question' => 'Is there a placement test?', 'answer' => 'Yes, a thorough placement assessment ensures you enter the right level.'],
                        ['question' => 'Are courses online or on-campus?', 'answer' => 'Both: interactive online classes and on-site sessions in our modern classrooms.'],
                        ['question' => 'Do I receive a certificate?', 'answer' => 'Yes, an official INTOK certificate stating completed level and hours is issued upon graduation.'],
                        ['question' => 'What is the duration per level?', 'answer' => 'Courses typically span 4 to 8 weeks depending on the selected regular or intensive track.'],
                    ],
                    'it' => [
                        ['question' => 'Si può iniziare da zero?', 'answer' => 'Assolutamente sì, i nostri corsi partono dal livello A1 per principianti assoluti fino al C2.'],
                        ['question' => 'C\'è un test di livello?', 'answer' => 'Sì, effettuiamo un test di piazzamento per individuare la classe più idonea.'],
                        ['question' => 'I corsi sono online o in presenza?', 'answer' => 'Offriamo entrambe le modalità: lezioni in sede e sessioni interattive online.'],
                        ['question' => 'Viene rilasciato un attestato?', 'answer' => 'Sì, al termine del corso viene rilasciato un certificato INTOK con livello e ore svolte.'],
                        ['question' => 'Quanto dura ciascun livello?', 'answer' => 'La durata media è compresa tra 4 e 8 settimane a seconda dell\'intensità scelta.'],
                    ],
                ],
                'badge' => ['ar' => 'من الصفر للاحتراف', 'en' => 'Beginner to Advanced', 'it' => 'Da Zero a Fluente'],
                'category_label' => ['ar' => 'تعليم اللغات', 'en' => 'Language Learning', 'it' => 'Formazione Linguistica'],
            ],

            // 03. التأهيل والتدريب للدراسة في أوروبا
            [
                'slug_ar' => 'study-in-europe',
                'slug_en' => 'study-in-europe',
                'slug_it' => 'studio-in-europa',
                'title' => [
                    'ar' => 'التأهيل والتدريب للدراسة في أوروبا',
                    'en' => 'Qualification for Study in Europe',
                    'it' => 'Preparazione agli Studi in Europa',
                ],
                'headline' => [
                    'ar' => 'ابدأ طريقك الأكاديمي نحو الجامعات الأوروبية',
                    'en' => 'Launch Your Academic Journey Toward European Universities',
                    'it' => 'Inizia il Tuo Percorso Accademico Verso le Università Europee',
                ],
                'summary' => [
                    'ar' => 'بنساعدك تجهز خطتك الأكاديمية للتقديم على المؤسسات التعليمية في الدول الأوروبية، من اختيار الدولة والتخصص المناسب، إلى تجهيز المستندات ومتابعة إجراءات التقديم والقبول.',
                    'en' => 'We assist you in building your academic pathway for European universities, from country and major selection to file preparation and admissions follow-up.',
                    'it' => 'Ti guidiamo nella pianificazione del percorso accademico in Europa, dalla scelta di paese e corso alla preparazione documenti e ammissione.',
                ],
                'description' => [
                    'ar' => 'بنساعدك تجهز خطتك الأكاديمية للتقديم على المؤسسات التعليمية في الدول الأوروبية، من اختيار الدولة والتخصص المناسب، إلى تجهيز المستندات ومتابعة إجراءات التقديم والقبول.',
                    'en' => 'We assist you in building your academic pathway for European universities, from country and major selection to file preparation and admissions follow-up.',
                    'it' => 'Ti guidiamo nella pianificazione del percorso accademico in Europa, dalla scelta di paese e corso alla preparazione documenti e ammissione.',
                ],
                'features' => [
                    'ar' => [
                        'التعرف على الدول والجامعات والتخصصات المتاحة.',
                        'تقييم المؤهل الدراسي ومدى ملاءمته للتقديم.',
                        'المساعدة في اختيار التخصص المناسب.',
                        'تجهيز ومراجعة ملف التقديم.',
                        'متابعة إجراءات التقديم ومتطلباته.',
                        'التعريف بالمنح والفرص التعليمية المتاحة وفق شروطها.',
                    ],
                    'en' => [
                        'Explore available European countries, universities, and disciplines.',
                        'Academic qualification evaluation for admission matching.',
                        'Expert guidance in choosing optimal study majors.',
                        'Preparation and meticulous review of the application dossier.',
                        'End-to-end follow-up on institutional admission procedures.',
                        'Guidance on European scholarship eligibility and funding opportunities.',
                    ],
                    'it' => [
                        'Panoramica di paesi, atenei e corsi di studio disponibili.',
                        'Valutazione dei titoli di studio e idoneità alla candidatura.',
                        'Orientamento specialistico nella scelta del corso accademico.',
                        'Preparazione e revisione della documentazione di iscrizione.',
                        'Monitoraggio di tutte le procedure di ammissione.',
                        'Informazioni dettagliate su borse di studio e agevolazioni.',
                    ],
                ],
                'requirements' => [
                    'ar' => [
                        'المؤهل الدراسي أو آخر شهادة دراسية.',
                        'بيان الدرجات.',
                        'جواز سفر ساري.',
                        'تحديد التخصص والدولة المفضلة.',
                        'أي مستندات إضافية تطلبها المؤسسة التعليمية.',
                    ],
                    'en' => [
                        'Latest diploma or educational qualification.',
                        'Official grade transcripts.',
                        'Valid passport.',
                        'Target country and desired academic major.',
                        'Any supplementary institution-specific documentation.',
                    ],
                    'it' => [
                        'Titolo di studio o ultimo diploma conseguito.',
                        'Certificato degli esami e dei voti (transcript).',
                        'Passaporto in corso di validità.',
                        'Preferenza su paese e indirizzo di studi.',
                        'Eventuali documenti aggiuntivi richiesti dall\'ateneo.',
                    ],
                ],
                'steps' => [
                    'ar' => [
                        'تقييم الحالة والمؤهل الدراسي.',
                        'تحديد الدولة والتخصص والجامعات المناسبة.',
                        'تجهيز المستندات المطلوبة.',
                        'متابعة التقديم وإجراءات القبول.',
                        'متابعة الخطوات التالية وفق متطلبات الجهة التعليمية.',
                    ],
                    'en' => [
                        'Evaluate student profile and qualifications.',
                        'Determine target European country, major, and matched universities.',
                        'Prepare and translate required documentation.',
                        'Submit applications and follow up on admission decisions.',
                        'Assist with subsequent university enrollment requirements.',
                    ],
                    'it' => [
                        'Valutazione del profilo e dei titoli di studio.',
                        'Scelta di paese, facoltà e atenei idonei.',
                        'Predisposizione di tutti i documenti richiesti.',
                        'Invio delle candidature e monitoraggio ammissione.',
                        'Supporto nelle fasi successive e perfezionamento immatricolazione.',
                    ],
                ],
                'faqs' => [
                    'ar' => [
                        ['question' => 'هل يمكن التقديم بأكثر من مؤهل دراسي؟', 'answer' => 'نعم، يمكنك التقديم بناءً على الثانوية العامة، الدبلومات الفنية، البكالوريوس، أو الماجستير وفق معايير ومتطلبات كل جامعة أوروبية.'],
                        ['question' => 'هل توجد فرص للمنح؟', 'answer' => 'نعم، نوفر إرشاداً شاملاً للتقديم على المنح الدراسية الإقليمية والحكومية في أوروبا (مثل منح DSU، الإعفاءات من المصروفات، والمساعدات المالية) وفق شروط كل جهة مانحة.'],
                        ['question' => 'هل يمكن التقديم بدون شهادة لغة؟', 'answer' => 'بعض البرامج والجامعات تتيح شروط قبول مشروط أو إجراء مقابلات بديلة، بينما تتطلب برامج أخرى شهادة معتمدة؛ ونحن نساعدك في التأهيل اللغوي المطلوب.'],
                        ['question' => 'ما الدول والتخصصات المتاحة؟', 'answer' => 'نغطي فرص الدراسة في أكثر من 10 دول أوروبية مثل إيطاليا، ألمانيا، فرنسا، إسبانيا وغيرها، في مختلف التخصصات الهندسية، الطبية، إدارة الأعمال، والعلوم الإنسانية.'],
                        ['question' => 'هل تختلف شروط القبول من جامعة لأخرى؟', 'answer' => 'نعم، لكل دولة وجامعة معايير قبول ومواعيد نهائية محددة، وفريقنا يوضح لك متطلبات كل جامعة بدقة ويتابع ملفك بالكامل.'],
                    ],
                    'en' => [
                        ['question' => 'Can I apply with different educational degrees?', 'answer' => 'Yes, applicants with high school diplomas, technical certificates, bachelors, or masters can qualify depending on university guidelines.'],
                        ['question' => 'Are there scholarship opportunities?', 'answer' => 'Yes, we guide you through regional European and government scholarship applications (such as DSU and tuition waivers).'],
                        ['question' => 'Can I apply without a language certificate?', 'answer' => 'Some universities offer conditional admission or alternative interviews, and we also provide preparation for required language tests.'],
                        ['question' => 'Which countries and disciplines are available?', 'answer' => 'We cover 10+ European destinations including Italy, Germany, France, and Spain across engineering, medicine, business, and humanities.'],
                        ['question' => 'Do requirements vary by university?', 'answer' => 'Yes, requirements and deadlines vary by institution; our team manages every requirement meticulously.'],
                    ],
                    'it' => [
                        ['question' => 'Posso candidarmi con diversi titoli di studio?', 'answer' => 'Sì, è possibile accedere con diploma di maturità, lauree triennali o magistrali a seconda dei requisiti.'],
                        ['question' => 'Ci sono opportunità di borse di studio?', 'answer' => 'Sì, forniamo assistenza per richiedere borse regionali (es. DSU) ed esoneri dalle tasse universitarie.'],
                        ['question' => 'Si può fare domanda senza certificato linguistico?', 'answer' => 'Alcuni atenei consentono ammissioni condizionate o colloqui, mentre altri richiedono certificazioni che aiutiamo a conseguire.'],
                        ['question' => 'Quali paesi e facoltà sono disponibili?', 'answer' => 'Copriamo oltre 10 paesi europei tra cui Italia, Germania e Francia in ingegneria, medicina ed economia.'],
                        ['question' => 'I criteri di ammissione variano tra atenei?', 'answer' => 'Sì, ciascun ateneo ha bandi e scadenze specifiche che seguiamo passo dopo passo.'],
                    ],
                ],
                'badge' => ['ar' => '10+ دول أوروبية', 'en' => '10+ European Countries', 'it' => '10+ Paesi Europei'],
                'category_label' => ['ar' => 'الدراسة والجامعات', 'en' => 'Study & Universities', 'it' => 'Studi Universitari'],
            ],

            // 04. التأهيل للعمل في مجال الكول سنتر
            [
                'slug_ar' => 'call-center-qualification',
                'slug_en' => 'call-center-qualification',
                'slug_it' => 'qualificazione-call-center',
                'title' => [
                    'ar' => 'التأهيل للعمل في مجال الكول سنتر',
                    'en' => 'Call Center Career Qualification',
                    'it' => 'Qualificazione per il Lavoro nei Call Center',
                ],
                'headline' => [
                    'ar' => 'اتأهل للعمل في كبرى شركات الكول سنتر',
                    'en' => 'Get Qualified for Top International Call Centers',
                    'it' => 'Qualificati per Lavorare nei Principali Call Center Internazionali',
                ],
                'summary' => [
                    'ar' => 'برنامج تدريبي عملي يهدف إلى تطوير مهارات التواصل وخدمة العملاء والتحدث باللغات الأجنبية، مع محاكاة مقابلات العمل ومواقف حقيقية تساعدك تكون مستعدًا لسوق العمل.',
                    'en' => 'Practical training program to master communication, customer service, and multilingual fluency, featuring real-world job interview simulations.',
                    'it' => 'Programma pratico volto a sviluppare capacità comunicative, assistenza clienti e fluidità linguistica con simulazioni di colloqui reali.',
                ],
                'description' => [
                    'ar' => 'برنامج تدريبي عملي يهدف إلى تطوير مهارات التواصل وخدمة العملاء والتحدث باللغات الأجنبية، مع محاكاة مقابلات العمل ومواقف حقيقية تساعدك تكون مستعدًا لسوق العمل.',
                    'en' => 'Practical training program to master communication, customer service, and multilingual fluency, featuring real-world job interview simulations.',
                    'it' => 'Programma pratico volto a sviluppare capacità comunicative, assistenza clienti e fluidità linguistica con simulazioni di colloqui reali.',
                ],
                'features' => [
                    'ar' => [
                        'تدريب على مهارات التواصل وخدمة العملاء.',
                        'محاكاة مكالمات ومواقف عمل حقيقية.',
                        'التدريب على التعامل مع الاعتراضات والمشكلات.',
                        'تطوير مهارات اللغة والمحادثة.',
                        'التدريب على مقابلات التوظيف.',
                        'إرشاد مهني للاستعداد لسوق العمل.',
                    ],
                    'en' => [
                        'Professional training in communication and customer experience.',
                        'Simulations of live customer scenarios and call handling.',
                        'Handling objections, conflict resolution, and problem solving.',
                        'Accent refinement and conversational fluency development.',
                        'Rigorous mock job interview preparation.',
                        'Career mentorship for rapid job market integration.',
                    ],
                    'it' => [
                        'Formazione su comunicazione e customer care d\'eccellenza.',
                        'Simulazione di chiamate e situazioni operative reali.',
                        'Gestione dei reclami e problem solving immediato.',
                        'Perfezionamento della pronuncia e fluidità nel parlato.',
                        'Preparazione mirata ai colloqui di selezione.',
                        'Orientamento professionale per l\'inserimento nel mercato.',
                    ],
                ],
                'requirements' => [
                    'ar' => [
                        'مستوى مناسب من اللغة حسب المسار.',
                        'الالتزام بحضور التدريب.',
                        'الرغبة في العمل بمجال خدمة العملاء.',
                    ],
                    'en' => [
                        'Target language baseline proficiency.',
                        'Commitment to attend all training modules.',
                        'Enthusiasm for customer service careers.',
                    ],
                    'it' => [
                        'Livello linguistico adeguato al percorso prescelto.',
                        'Presenza costante alle sessioni formative.',
                        'Motivazione a lavorare nel settore del customer service.',
                    ],
                ],
                'steps' => [
                    'ar' => [
                        'تقييم المستوى اللغوي.',
                        'تحديد المسار التدريبي المناسب.',
                        'حضور التدريب العملي والمحاكاة.',
                        'التدريب على مقابلات العمل.',
                        'الاستعداد للتقديم على الفرص المناسبة.',
                    ],
                    'en' => [
                        'Language level evaluation.',
                        'Selection of tailored training track.',
                        'Hands-on interactive call simulation training.',
                        'Intensive mock job interview drills.',
                        'Readiness to apply to premier hiring opportunities.',
                    ],
                    'it' => [
                        'Test di valutazione linguistica.',
                        'Definizione del percorso più idoneo.',
                        'Frequenza dei laboratori pratici di simulazione.',
                        'Esercitazioni sui colloqui di assunzione.',
                        'Candidatura presso le aziende partner selezionate.',
                    ],
                ],
                'faqs' => [
                    'ar' => [
                        ['question' => 'هل يشترط وجود خبرة سابقة؟', 'answer' => 'لا يشترط وجود خبرة سابقة؛ البرنامج يبدأ معك من أساسيات خدمة العملاء وحتى احتراف المكالمات وحل المشكلات.'],
                        ['question' => 'هل يوجد تدريب للمبتدئين؟', 'answer' => 'نعم، نوفر مساراً تدريبياً تمهيدياً للمبتدئين لرفع مهارات الطلاقة والتحدث والتواصل قبل الانتقال لمرحلة المحاكاة المتقدمة.'],
                        ['question' => 'ما اللغات المتاحة؟', 'answer' => 'يتوفر التدريب للغات الأكثر طلباً في سوق الكول سنتر مثل الإيطالية، الإنجليزية، الألمانية، والفرنسية.'],
                        ['question' => 'هل يوجد ترشيح لفرص عمل؟', 'answer' => 'نعم، بفضل شبكة شركاء INTOK مع كبرى شركات التعهيد ومراكز الاتصال الدولية، نقوم بتوصيل وترشيح الخريجين المتميزين للمقابلات الوظيفية.'],
                        ['question' => 'هل التوظيف مضمون؟', 'answer' => 'قرار التوظيف يعتمد على أداء المتدرب في مقابلة الشركة، ودورنا هو تأهيلك بنسبة 100% لاجتياز المقابلات والاختبارات الفنية بنجاح وثقة.'],
                    ],
                    'en' => [
                        ['question' => 'Is prior experience required?', 'answer' => 'No experience needed; the program starts from communication foundations up to advanced problem resolution.'],
                        ['question' => 'Is training available for beginners?', 'answer' => 'Yes, preparatory tracks help build fluency before moving into full live simulations.'],
                        ['question' => 'Which languages are in high demand?', 'answer' => 'Italian, English, German, and French are the most sought-after in multinational contact centers.'],
                        ['question' => 'Do you refer candidates for job openings?', 'answer' => 'Yes, our corporate network connects standout graduates directly to company interview rounds.'],
                        ['question' => 'Is hiring guaranteed?', 'answer' => 'Final hiring decisions rest with the employer; our mission is 100% qualification to pass every interview.'],
                    ],
                    'it' => [
                        ['question' => 'È richiesta esperienza pregressa?', 'answer' => 'No, il corso parte dalle basi fino alla gestione avanzata della clientela.'],
                        ['question' => 'Ci sono corsi per principianti?', 'answer' => 'Sì, è previsto un modulo propedeutico per potenziare il vocabolario prima delle simulazioni.'],
                        ['question' => 'Quali lingue sono richieste?', 'answer' => 'Italiano, inglese, tedesco e francese sono le più richieste dalle multinazionali.'],
                        ['question' => 'Segnalate i candidati alle aziende?', 'answer' => 'Sì, grazie ai nostri partner aziendali raccomandiamo gli studenti più meritevoli per i colloqui.'],
                        ['question' => 'L\'assunzione è garantita?', 'answer' => 'La decisione finale spetta all\'azienda; noi garantiamo la massima preparazione per superare la selezione.'],
                    ],
                ],
                'badge' => ['ar' => 'جاهزية لسوق العمل', 'en' => 'Job-Ready Training', 'it' => 'Pronto per il Lavoro'],
                'category_label' => ['ar' => 'التدريب والتأهيل المهني', 'en' => 'Career Training', 'it' => 'Qualificazione Professionale'],
            ],

            // 05. التأهيل لاحتراف الترجمة
            [
                'slug_ar' => 'translation-qualification',
                'slug_en' => 'translation-qualification',
                'slug_it' => 'qualificazione-traduzione',
                'title' => [
                    'ar' => 'التأهيل لاحتراف الترجمة',
                    'en' => 'Professional Translation Qualification',
                    'it' => 'Qualificazione Professionale alla Traduzione',
                ],
                'headline' => [
                    'ar' => 'حوّل إتقانك للغة إلى مهارة احترافية في الترجمة',
                    'en' => 'Transform Language Mastery into a Professional Translation Career',
                    'it' => 'Trasforma la Tua Padronanza Linguistica in una Carriera da Traduttore',
                ],
                'summary' => [
                    'ar' => 'برنامج تدريبي متخصص يساعدك على اكتساب أساسيات ومهارات الترجمة الاحترافية، والتعامل مع النصوص المختلفة، وتطوير قدرتك على العمل في المجال بكفاءة.',
                    'en' => 'Specialized program to acquire translation methodologies, handle diverse professional text genres, and launch a successful freelance or corporate translation career.',
                    'it' => 'Corso specialistico per apprendere tecniche di traduzione professionale, gestire testi complessi e operare nel settore con elevata competenza.',
                ],
                'description' => [
                    'ar' => 'برنامج تدريبي متخصص يساعدك على اكتساب أساسيات ومهارات الترجمة الاحترافية، والتعامل مع النصوص المختلفة، وتطوير قدرتك على العمل في المجال بكفاءة.',
                    'en' => 'Specialized program to acquire translation methodologies, handle diverse professional text genres, and launch a successful freelance or corporate translation career.',
                    'it' => 'Corso specialistico per apprendere tecniche di traduzione professionale, gestire testi complessi e operare nel settore con elevata competenza.',
                ],
                'features' => [
                    'ar' => [
                        'تعلم أساسيات ومناهج الترجمة.',
                        'التدريب على الترجمة التحريرية.',
                        'التعرف على أنواع النصوص والتخصصات.',
                        'تطوير مهارات البحث والمصطلحات.',
                        'مراجعة الأخطاء وتحسين جودة الترجمة.',
                        'تدريبات عملية على مشروعات ترجمة.',
                    ],
                    'en' => [
                        'Master fundamental translation principles and theories.',
                        'In-depth written translation workshops.',
                        'Handling legal, academic, commercial, and technical texts.',
                        'Terminology research and specialized glossaries management.',
                        'Error analysis and rigorous quality assurance.',
                        'Real-world portfolio projects and client brief execution.',
                    ],
                    'it' => [
                        'Apprendimento delle metodologie e teorie della traduzione.',
                        'Esercitazioni pratiche di traduzione scritta.',
                        'Approfondimento di testi legali, accademici e commerciali.',
                        'Ricerca terminologica e gestione dei glossari.',
                        'Controllo qualità e correzione degli errori frequenti.',
                        'Progetti pratici e creazione di un portfolio professionale.',
                    ],
                ],
                'requirements' => [
                    'ar' => [
                        'إجادة مناسبة للغة المراد التخصص فيها.',
                        'اجتياز تقييم المستوى عند الحاجة.',
                        'الالتزام بالتدريبات والتطبيقات العملية.',
                    ],
                    'en' => [
                        'Proficiency in source and target languages.',
                        'Passing placement check where required.',
                        'Commitment to practical assignments and translation briefs.',
                    ],
                    'it' => [
                        'Buona conoscenza della lingua di partenza e di arrivo.',
                        'Superamento del test iniziale se richiesto.',
                        'Costanza nello svolgimento delle esercitazioni pratiche.',
                    ],
                ],
                'steps' => [
                    'ar' => [
                        'تقييم المستوى اللغوي.',
                        'تحديد المسار التدريبي.',
                        'دراسة المهارات الأساسية والمتخصصة.',
                        'تنفيذ تدريبات ومشروعات عملية.',
                        'تقييم المستوى النهائي.',
                    ],
                    'en' => [
                        'Assess initial language capabilities.',
                        'Select specialized translation specialization.',
                        'Study core and domain-specific translation skills.',
                        'Execute real client-style translation projects.',
                        'Final portfolio evaluation and certification.',
                    ],
                    'it' => [
                        'Valutazione delle competenze linguistiche.',
                        'Scelta della specializzazione di traduzione.',
                        'Studio delle tecniche e dei linguaggi settoriali.',
                        'Esecuzione di progetti e commesse reali.',
                        'Valutazione finale e rilascio attestato.',
                    ],
                ],
                'faqs' => [
                    'ar' => [
                        ['question' => 'هل يمكن للمبتدئين الالتحاق؟', 'answer' => 'يشترط توفر مستوى لغوي جيد في لغة المصدر والهدف (B1/B2 كحد أدنى) للاستفادة الكاملة من تقنيات ومناهج الترجمة الاحترافية.'],
                        ['question' => 'هل يشترط إتقان اللغة؟', 'answer' => 'نعم، يجب امتلاك فهم قوي لقواعد وتراكيب اللغة، حيث يركز البرنامج على فنون الصياغة والترجمة المتخصصة وتطبيقاتها العملية.'],
                        ['question' => 'ما أنواع الترجمة التي يتم التدريب عليها؟', 'answer' => 'نغطي الترجمة القانونية، الأكاديمية، التجارية، الطبية، التقنية، مع تدريب على أدوات الـ CAT Tools وبرامج مساعدة المترجم.'],
                        ['question' => 'هل توجد شهادة بعد انتهاء التدريب؟', 'answer' => 'نعم، يُمنح المتدرب شهادة معتمدة من INTOK Academy تثبت اجتيازه بنجاح لبرنامج تأهيل المترجمين المحترفين وساعات التدريب العملي.'],
                        ['question' => 'هل يؤهلني البرنامج للعمل كمترجم؟', 'answer' => 'نعم، التدريب يركز على المشروعات الواقعية ومتطلبات سوق العمل الحر والشركات، مما يجعلك جاهزاً لتقديم خدماتك للمؤسسات ومكاتب الترجمة.'],
                    ],
                    'en' => [
                        ['question' => 'Can absolute beginners join?', 'answer' => 'A solid baseline (B1/B2 minimum) in both languages is required to benefit from professional translation methodologies.'],
                        ['question' => 'Is language mastery required?', 'answer' => 'Yes, strong grammar and stylistic grasp are essential, as the course focuses on applied translation craft.'],
                        ['question' => 'Which translation fields are covered?', 'answer' => 'Legal, academic, commercial, and technical translation, alongside modern CAT Tools overview.'],
                        ['question' => 'Is a certificate awarded?', 'answer' => 'Yes, graduates receive an official certificate from INTOK Academy documenting practical training hours.'],
                        ['question' => 'Does this qualify me for freelance work?', 'answer' => 'Yes, the hands-on project work equips you directly for agency and freelance opportunities.'],
                    ],
                    'it' => [
                        ['question' => 'Possono partecipare i principianti?', 'answer' => 'È richiesta una conoscenza linguistica intermedia (B1/B2) per poter apprendere le tecniche di traduzione.'],
                        ['question' => 'È necessario padroneggiare la lingua?', 'answer' => 'Sì, una solida base grammaticale è fondamentale poiché il corso si concentra sulle tecniche traduttive.'],
                        ['question' => 'Quali settori di traduzione sono trattati?', 'answer' => 'Traduzione giuridica, accademica, economica e tecnica con introduzione ai software CAT.'],
                        ['question' => 'Si ottiene un certificato finale?', 'answer' => 'Sì, viene rilasciato un attestato di qualificazione professionale certificato INTOK.'],
                        ['question' => 'Il corso abilita al lavoro freelance?', 'answer' => 'Sì, la formazione orientata a commesse reali prepara all\'attività professionale autonoma o in agenzia.'],
                    ],
                ],
                'badge' => ['ar' => 'احتراف وتطبيق عملي', 'en' => 'Professional Practice', 'it' => 'Pratica Professionale'],
                'category_label' => ['ar' => 'الترجمة والاعتماد', 'en' => 'Translation & Certification', 'it' => 'Traduzione & Asseverazione'],
            ],

            // 06. التأهيل لاجتياز الاختبارات الدولية للدراسة
            [
                'slug_ar' => 'university-admission-exams',
                'slug_en' => 'university-admission-exams',
                'slug_it' => 'esami-ammissione-universitaria',
                'title' => [
                    'ar' => 'التأهيل لاجتياز الاختبارات الدولية للدراسة',
                    'en' => 'International University Admission Exams Prep',
                    'it' => 'Preparazione Test di Ammissione Universitaria',
                ],
                'headline' => [
                    'ar' => 'استعد لاجتياز اختبارات القبول الجامعي الدولية',
                    'en' => 'Prepare to Pass International University Admission Exams',
                    'it' => 'Preparati a Superare i Test di Ammissione Universitaria Internazionale',
                ],
                'summary' => [
                    'ar' => 'برامج تدريبية تساعدك على الاستعداد للاختبارات المطلوبة للالتحاق بالجامعات، من خلال التعرف على طبيعة الاختبار والتدريب على نماذجه وتطوير المهارات اللازمة لأدائه.',
                    'en' => 'Training programs preparing you for European and global university entrance exams through mock tests, syllabus breakdown, and analytical reasoning skills.',
                    'it' => 'Programmi di preparazione per i test di ingresso universitari europei, con esercitazioni mirate e strategie per massimizzare il punteggio.',
                ],
                'description' => [
                    'ar' => 'برامج تدريبية تساعدك على الاستعداد للاختبارات المطلوبة للالتحاق بالجامعات، من خلال التعرف على طبيعة الاختبار والتدريب على نماذجه وتطوير المهارات اللازمة لأدائه.',
                    'en' => 'Training programs preparing you for European and global university entrance exams through mock tests, syllabus breakdown, and analytical reasoning skills.',
                    'it' => 'Programmi di preparazione per i test di ingresso universitari europei, con esercitazioni mirate e strategie per massimizzare il punteggio.',
                ],
                'features' => [
                    'ar' => [
                        'التعرف على متطلبات الاختبارات.',
                        'التدريب على نماذج وأسئلة مشابهة.',
                        'شرح طبيعة الاختبار وأقسامه.',
                        'تدريبات عملية وتقييم مستمر.',
                        'تحديد نقاط القوة والضعف.',
                        'خطة استعداد مناسبة لمستواك.',
                    ],
                    'en' => [
                        'Comprehensive understanding of exam requirements and structures.',
                        'Extensive drills on past papers and authentic question banks.',
                        'Detailed breakdown of scientific, mathematical, and logic sections.',
                        'Timed mock tests and regular performance analytics.',
                        'Targeted diagnosis of strengths and areas for improvement.',
                        'Personalized study plans calibrated to exam date.',
                    ],
                    'it' => [
                        'Comprensione approfondita della struttura e dei requisiti dei test.',
                        'Esercitazioni su simulazioni d\'esame e quesiti ufficiali.',
                        'Spiegazione dettagliata delle sezioni scientifiche, logiche e matematiche.',
                        'Simulazioni a tempo e valutazione continua dei progressi.',
                        'Individuazione di punti di forza e aree di miglioramento.',
                        'Piano di studio personalizzato in base alla data dell\'esame.',
                    ],
                ],
                'requirements' => [
                    'ar' => [
                        'تحديد الجامعة أو التخصص المستهدف.',
                        'معرفة الاختبار المطلوب إن وجد.',
                        'الالتزام بالتدريبات والاختبارات التجريبية.',
                    ],
                    'en' => [
                        'Target university or field of study identified.',
                        'Specific exam requirements verified.',
                        'Dedication to mock testing and practice sessions.',
                    ],
                    'it' => [
                        'Individuazione dell\'ateneo o del corso desiderato.',
                        'Conoscenza del test richiesto (es. TOLC, IMAT).',
                        'Impegno nelle simulazioni e nei compiti assegnati.',
                    ],
                ],
                'steps' => [
                    'ar' => [
                        'تحديد الاختبار المطلوب.',
                        'تقييم المستوى الحالي.',
                        'وضع خطة تدريب مناسبة.',
                        'التدريب على نماذج الاختبار.',
                        'تقييم الجاهزية قبل موعد الاختبار.',
                    ],
                    'en' => [
                        'Identify required exam format (e.g. TOLC, IMAT, SAT).',
                        'Baseline diagnostic assessment.',
                        'Formulate structured preparation timeline.',
                        'Practice with section drills and full-length tests.',
                        'Final readiness evaluation and test-day strategy.',
                    ],
                    'it' => [
                        'Identificazione della tipologia di test.',
                        'Valutazione diagnostica iniziale.',
                        'Elaborazione del piano di preparazione.',
                        'Esercitazioni intensive sui moduli di prova.',
                        'Verifica finale della preparazione prima dell\'esame.',
                    ],
                ],
                'faqs' => [
                    'ar' => [
                        ['question' => 'ما الاختبارات المتاحة للتدريب؟', 'answer' => 'نؤهل لاختبارات القبول الجامعي الأوروبية والدولية مثل اختبارات TOLC بأنواعها (TOLC-E, TOLC-I, TOLC-F وغيرها)، اختبارات IMAT للطب، SAT، وغيرها.'],
                        ['question' => 'هل التدريب مناسب للمبتدئين؟', 'answer' => 'نعم، نبدأ بمراجعة المفاهيم العلمية والرياضية والمنطقية الأساسية وفق هيكل الاختبار لتغطية أي فجوة معرفية.'],
                        ['question' => 'هل يوجد اختبار تجريبي؟', 'answer' => 'نعم، يجري المتدرب اختبارات محاكاة دورية بنفس التوقيت ونظام الدرجات الواقعي للاختبار الرسمي لقياس التطور.'],
                        ['question' => 'كم تستغرق فترة الاستعداد؟', 'answer' => 'تتراوح فترة الإعداد بين 4 إلى 12 أسبوعاً حسب مستوى الطالب وتاريخ انعقاد جولة الاختبار المستهدفة.'],
                        ['question' => 'هل يمكن التدريب على أكثر من اختبار؟', 'answer' => 'نعم، يمكن تخصيص خطة تدريب مدمجة إذا كنت تخطط للتقديم على أكثر من برنامج أو تخصص جامعي.'],
                    ],
                    'en' => [
                        ['question' => 'Which exams are covered?', 'answer' => 'European and international exams such as TOLC variants (TOLC-E, TOLC-I, etc.), IMAT for medicine, and SAT.'],
                        ['question' => 'Is it suitable for beginner students?', 'answer' => 'Yes, core math, logic, and scientific concepts are reviewed step-by-step.'],
                        ['question' => 'Are there mock exams?', 'answer' => 'Yes, regular timed mock exams simulate official testing conditions and scoring algorithms.'],
                        ['question' => 'How long is the preparation period?', 'answer' => 'Typically between 4 to 12 weeks based on student baseline and exam calendar.'],
                        ['question' => 'Can I prepare for multiple exams simultaneously?', 'answer' => 'Yes, bundled modular tracks are available for students applying to multiple university options.'],
                    ],
                    'it' => [
                        ['question' => 'Quali test sono coperti?', 'answer' => 'Test universitari internazionali tra cui TOLC (TOLC-E, TOLC-I, ecc.), IMAT per medicina e SAT.'],
                        ['question' => 'È adatto anche a chi ha lacune di base?', 'answer' => 'Sì, ripassiamo concetti matematici, logici e scientifici essenziali prima di passare ai quiz.'],
                        ['question' => 'Ci sono simulazioni d\'esame?', 'answer' => 'Sì, vengono svolte simulazioni con tempi e punteggi equivalenti al test reale.'],
                        ['question' => 'Quanto dura il percorso di preparazione?', 'answer' => 'Da 4 a 12 settimane in base al livello iniziale e alla sessione d\'esame prescelta.'],
                        ['question' => 'Si possono preparare più test contemporaneamente?', 'answer' => 'Sì, offriamo percorsi combinati per chi partecipa a più selezioni universitarie.'],
                    ],
                ],
                'badge' => ['ar' => 'TOLC • IMAT • SAT', 'en' => 'TOLC • IMAT • SAT', 'it' => 'TOLC • IMAT • SAT'],
                'category_label' => ['ar' => 'الاختبارات والشهادات الدولية', 'en' => 'International Exams', 'it' => 'Test Internazionali'],
            ],

            // 07. التأهيل لاجتياز اختبارات شهادات اللغة الدولية
            [
                'slug_ar' => 'international-language-certificates',
                'slug_en' => 'international-language-certificates',
                'slug_it' => 'certificazioni-linguistiche-internazionali',
                'title' => [
                    'ar' => 'التأهيل لاجتياز اختبارات شهادات اللغة الدولية',
                    'en' => 'International Language Certificates Prep',
                    'it' => 'Preparazione Certificazioni Linguistiche Internazionali',
                ],
                'headline' => [
                    'ar' => 'جهّز نفسك للحصول على شهادة لغة دولية',
                    'en' => 'Get Ready to Earn an Accredited International Language Certificate',
                    'it' => 'Preparati a Conseguire una Certificazione Linguistica Internazionale',
                ],
                'summary' => [
                    'ar' => 'تدريب متخصص للاستعداد لاختبارات وشهادات قياس مستوى اللغة، من خلال التعرف على نظام كل اختبار والتدريب على مهاراته وأقسامه وفق مستواك وهدفك.',
                    'en' => 'Targeted prep for international language proficiency certifications, mastering exam formats, scoring criteria, and four-skill competencies.',
                    'it' => 'Preparazione mirata per le certificazioni linguistiche ufficiali, con allenamento su formati d\'esame e criteri di punteggio.',
                ],
                'description' => [
                    'ar' => 'تدريب متخصص للاستعداد لاختبارات وشهادات قياس مستوى اللغة، من خلال التعرف على نظام كل اختبار والتدريب على مهاراته وأقسامه وفق مستواك وهدفك.',
                    'en' => 'Targeted prep for international language proficiency certifications, mastering exam formats, scoring criteria, and four-skill competencies.',
                    'it' => 'Preparazione mirata per le certificazioni linguistiche ufficiali, con allenamento su formati d\'esame e criteri di punteggio.',
                ],
                'features' => [
                    'ar' => [
                        'التدريب على IELTS وTOEFL.',
                        'التدريب على CILS وCELI وPLIDA.',
                        'التعرف على نظام كل اختبار.',
                        'تطوير مهارات القراءة والاستماع والكتابة والمحادثة.',
                        'اختبارات تجريبية وتقييم الأداء.',
                        'خطة تدريب تناسب الدرجة المستهدفة.',
                    ],
                    'en' => [
                        'Preparation for IELTS and TOEFL examinations.',
                        'Specialized preparation for Italian CILS, CELI, and PLIDA certificates.',
                        'Detailed breakdown of test scoring criteria.',
                        'Dedicated development of Reading, Listening, Writing, and Speaking.',
                        'Authentic practice tests and detailed score feedback.',
                        'Personalized training geared toward target band score.',
                    ],
                    'it' => [
                        'Preparazione per certificazioni di inglese (IELTS, TOEFL).',
                        'Corsi per certificati di italiano ufficiale (CILS, CELI, PLIDA).',
                        'Analisi dettagliata dei criteri di valutazione di ciascun esame.',
                        'Sviluppo mirato di lettura, ascolto, scrittura e parlato.',
                        'Simulazioni d\'esame e feedback dettagliato sui punteggi.',
                        'Piano di studio calibrato sul livello di punteggio desiderato.',
                    ],
                ],
                'requirements' => [
                    'ar' => [
                        'تحديد الشهادة المطلوبة.',
                        'تحديد الدرجة المستهدفة.',
                        'تقييم المستوى اللغوي.',
                        'الالتزام بالخطة التدريبية.',
                    ],
                    'en' => [
                        'Target certificate specified.',
                        'Required target score/band identified.',
                        'Preliminary skill evaluation.',
                        'Commitment to personalized training schedule.',
                    ],
                    'it' => [
                        'Scelta della certificazione necessaria.',
                        'Definizione del livello o punteggio obiettivo.',
                        'Valutazione preliminare delle competenze.',
                        'Impegno costante nel seguire il programma didattico.',
                    ],
                ],
                'steps' => [
                    'ar' => [
                        'تحديد الشهادة والدرجة المطلوبة.',
                        'إجراء تقييم للمستوى.',
                        'وضع خطة الاستعداد.',
                        'التدريب على أقسام الاختبار.',
                        'إجراء اختبارات تجريبية وتقييم الجاهزية.',
                    ],
                    'en' => [
                        'Select certificate and target score.',
                        'Undergo placement assessment.',
                        'Establish tailored study timeline.',
                        'Master test sections through targeted drills.',
                        'Take full-length mock exams and review readiness.',
                    ],
                    'it' => [
                        'Scelta della certificazione e del punteggio minimo richiesto.',
                        'Esecuzione del test diagnostico.',
                        'Pianificazione della tabella di marcia.',
                        'Esercitazioni mirate sulle diverse prove d\'esame.',
                        'Simulazioni finali e verifica del livello raggiunto.',
                    ],
                ],
                'faqs' => [
                    'ar' => [
                        ['question' => 'ما الشهادات المتاحة؟', 'answer' => 'نؤهل لاختبارات اللغة الإيطالية المعتمدة رسمياً (CILS, CELI, PLIDA, CERT.IT) واختبارات اللغة الإنجليزية (IELTS, TOEFL, Duolingo)، واللغات الأخرى.'],
                        ['question' => 'هل يمكن تحديد الدرجة المستهدفة؟', 'answer' => 'نعم، نحدد معك الدرجة أو المستوى المطلوب للجهة المستهدفة (مثلاً B1, B2 أو Band 6.5+) ونبني الخطة التدريبية لتحقيقها.'],
                        ['question' => 'هل يوجد اختبار تحديد مستوى؟', 'answer' => 'نعم، يتم عمل تقييم دقيق للمهارات الأربع (الاستماع، القراءة، الكتابة، المحادثة) لتحديد نقاط التركيز المطلوبة.'],
                        ['question' => 'هل يمكن التدريب أونلاين؟', 'answer' => 'نعم، التدريب متاح أونلاين عبر فصول تفاعلية مباشرة مع المدرب، بالإضافة للمحاضرات الحية داخل مقراتنا.'],
                        ['question' => 'هل تضمن الأكاديمية الحصول على درجة معينة؟', 'answer' => 'نوفر أعلى جودة تدريبية وتدريبات مكثفة ومحاكاة كاملة تضمن وصولك لأعلى جاهزية وتحقيق الدرجة المطلوبة بمشيئة الله عند التزامك بالخطة.'],
                    ],
                    'en' => [
                        ['question' => 'Which certificates are offered?', 'answer' => 'Official Italian certifications (CILS, CELI, PLIDA) and English exams (IELTS, TOEFL, Duolingo).'],
                        ['question' => 'Can we target a specific band score?', 'answer' => 'Yes, whether you need B1, B2, or IELTS 6.5+, our training is calibrated to hit that benchmark.'],
                        ['question' => 'Is there a preliminary placement assessment?', 'answer' => 'Yes, a 4-skill diagnostic test reveals your starting baseline.'],
                        ['question' => 'Can I study online?', 'answer' => 'Yes, live instructor-led virtual classes and in-person academy sessions are available.'],
                        ['question' => 'Is the target score guaranteed?', 'answer' => 'We provide premier exam techniques and repeated simulations that ensure peak readiness when you adhere to the study plan.'],
                    ],
                    'it' => [
                        ['question' => 'Quali certificazioni sono previste?', 'answer' => 'Certificati di lingua italiana (CILS, CELI, PLIDA) e lingua inglese (IELTS, TOEFL).'],
                        ['question' => 'Si può mirare a un punteggio preciso?', 'answer' => 'Certamente, sia che serva un livello B1/B2 o IELTS 6.5+, il piano è tarato sul traguardo.'],
                        ['question' => 'C\'è un test d\'ingresso?', 'answer' => 'Sì, valutiamo le 4 abilità per calibrare le lezioni.'],
                        ['question' => 'I corsi si possono svolgere online?', 'answer' => 'Sì, in aule virtuali dal vivo con il docente oppure in presenza presso la nostra sede.'],
                        ['question' => 'Il punteggio è garantito?', 'answer' => 'Garantiamo la massima qualità didattica e simulazioni continue che portano alla massima preparazione.'],
                    ],
                ],
                'badge' => ['ar' => 'CILS • CELI • IELTS', 'en' => 'CILS • CELI • IELTS', 'it' => 'CILS • CELI • IELTS'],
                'category_label' => ['ar' => 'الاختبارات والشهادات الدولية', 'en' => 'International Exams', 'it' => 'Test Internazionali'],
            ],

            // 08. خدمة الحصول على قبول جامعي وثانوي
            [
                'slug_ar' => 'university-school-admission',
                'slug_en' => 'university-school-admission',
                'slug_it' => 'ammissione-universitaria-scolastica',
                'title' => [
                    'ar' => 'خدمة الحصول على قبول جامعي وثانوي',
                    'en' => 'University & Secondary School Admission Service',
                    'it' => 'Ammissione Universitaria e Scolastica',
                ],
                'headline' => [
                    'ar' => 'ابدأ إجراءات القبول في المؤسسات التعليمية المناسبة',
                    'en' => 'Start Your Admission Process in Top Matching Institutions',
                    'it' => 'Avvia le Pratiche di Ammissione Negli Istituti Più Idonei',
                ],
                'summary' => [
                    'ar' => 'بنساعدك في البحث عن المؤسسات التعليمية المناسبة لمؤهلك وهدفك، وتجهيز مستندات التقديم ومتابعة الإجراءات المطلوبة للحصول على قرار القبول وفق شروط الجهة التعليمية.',
                    'en' => 'We assist you in finding matching educational institutions, preparing admission files, and tracking applications until formal decision issuance.',
                    'it' => 'Ti aiutiamo a selezionare gli istituti idonei, preparare i documenti di domanda e monitorare le pratiche fino alla delibera di ammissione.',
                ],
                'description' => [
                    'ar' => 'بنساعدك في البحث عن المؤسسات التعليمية المناسبة لمؤهلك وهدفك، وتجهيز مستندات التقديم ومتابعة الإجراءات المطلوبة للحصول على قرار القبول وفق شروط الجهة التعليمية.',
                    'en' => 'We assist you in finding matching educational institutions, preparing admission files, and tracking applications until formal decision issuance.',
                    'it' => 'Ti aiutiamo a selezionare gli istituti idonei, preparare i documenti di domanda e monitorare le pratiche fino alla delibera di ammissione.',
                ],
                'features' => [
                    'ar' => [
                        'البحث عن المؤسسات التعليمية المناسبة.',
                        'مراجعة شروط القبول والتخصصات.',
                        'تقييم المؤهل الدراسي.',
                        'تجهيز ومراجعة مستندات التقديم.',
                        'متابعة الطلب مع المؤسسة التعليمية.',
                        'إرشادك بشأن المستندات والخطوات التالية.',
                    ],
                    'en' => [
                        'Targeted search for suitable universities and secondary schools.',
                        'Comprehensive review of admission requirements and quotas.',
                        'Evaluation of academic credentials and credit transfers.',
                        'Complete dossier preparation and official translation coordination.',
                        'Direct follow-up with institutional registrar offices.',
                        'Clear guidance on visa and post-admission onboarding.',
                    ],
                    'it' => [
                        'Ricerca mirata degli istituti scolastici e accademici più adatti.',
                        'Verifica dei requisiti di ammissione e dei posti disponibili.',
                        'Valutazione dei titoli di studio e delle equivalenze.',
                        'Preparazione e revisione del fascicolo di candidatura.',
                        'Rapporti diretti con le segreterie degli atenei e degli istituti.',
                        'Orientamento sulle pratiche successive all\'ammissione.',
                    ],
                ],
                'requirements' => [
                    'ar' => [
                        'آخر مؤهل دراسي.',
                        'بيان الدرجات.',
                        'جواز سفر أو إثبات هوية حسب متطلبات الجهة.',
                        'تحديد المرحلة الدراسية والتخصص المطلوب.',
                        'المستندات الإضافية المطلوبة حسب المؤسسة.',
                    ],
                    'en' => [
                        'Latest diploma or certificate.',
                        'Official transcript of records.',
                        'Valid passport or identification.',
                        'Target study level and desired major.',
                        'Supplementary institution-specific prerequisites.',
                    ],
                    'it' => [
                        'Ultimo titolo di studio conseguito.',
                        'Certificato dei voti e degli esami.',
                        'Passaporto o documento d\'identità valido.',
                        'Indicazione del livello di studio e del corso scelto.',
                        'Ulteriori documenti richiesti dall\'istituto ricevente.',
                    ],
                ],
                'steps' => [
                    'ar' => [
                        'مراجعة المؤهل الدراسي.',
                        'تحديد المؤسسات المناسبة.',
                        'تجهيز ملف التقديم.',
                        'تقديم الطلب ومتابعته.',
                        'استلام ومراجعة رد المؤسسة التعليمية.',
                    ],
                    'en' => [
                        'Review applicant credentials.',
                        'Identify matched institutions and programs.',
                        'Compile and finalize the admission dossier.',
                        'Submit applications and actively track status.',
                        'Receive and review the formal admission notice.',
                    ],
                    'it' => [
                        'Esame dei titoli e del percorso scolastico.',
                        'Individuazione degli istituti più compatibili.',
                        'Composizione del fascicolo di domanda.',
                        'Presentazione della candidatura e monitoraggio continuo.',
                        'Ricezione e verifica dell\'esito di ammissione.',
                    ],
                ],
                'faqs' => [
                    'ar' => [
                        ['question' => 'هل الخدمة للجامعات فقط؟', 'answer' => 'لا، الخدمة تغطي القبول في المدارس الثانوية الدولية، معاهد التدريب المهني، الجامعات لمرحلة البكالوريوس، وبرامج الماجستير والدكتوراه.'],
                        ['question' => 'هل يمكن الحصول على قبول للمرحلة الثانوية؟', 'answer' => 'نعم، نساعد في التقديم للمدارس الثانوية الأوروبية ونظام التبادل الطلابي وبرامج السنة التأهيلية (Foundation Year).'],
                        ['question' => 'هل تختلف الشروط حسب الدولة؟', 'answer' => 'نعم، تختلف متطلبات الاعتراف بالشهادات ومعادلتها والمواعيد حسب نظام التعليم في كل دولة، وفريقنا يوجهك للخطوات الصحيحة.'],
                        ['question' => 'هل يمكن التقديم لأكثر من جامعة؟', 'answer' => 'نعم، ننصح دائماً بوضع قائمة رغبات متوازنة والتقديم لأكثر من جامعة لزيادة فرص الحصول على القبول الأكاديمي.'],
                        ['question' => 'هل القبول مضمون؟', 'answer' => 'القرار النهائي يعود للجامعة وفق استيفاء الشروط وتنافسية المقاعد، ونحن نضمن إعداد ملف تقديم متكامل وخالٍ من الأخطاء بأعلى معايير التنافسية.'],
                    ],
                    'en' => [
                        ['question' => 'Is this service only for universities?', 'answer' => 'No, it covers secondary schools, vocational colleges, bachelors, masters, and foundation programs.'],
                        ['question' => 'Can high school students apply?', 'answer' => 'Yes, we assist with European secondary schools, student exchange programs, and Foundation Years.'],
                        ['question' => 'Do requirements differ by country?', 'answer' => 'Yes, credential legalization and deadlines differ across Europe; our advisors steer the process smoothly.'],
                        ['question' => 'Can I apply to multiple universities?', 'answer' => 'Yes, we recommend applying to several institutions to maximize admission odds.'],
                        ['question' => 'Is admission guaranteed?', 'answer' => 'Final decision rests with the academic institution; we ensure your application file is flawless and competitive.'],
                    ],
                    'it' => [
                        ['question' => 'Il servizio è solo per le università?', 'answer' => 'No, include anche scuole secondarie, corsi professionali e Foundation Year.'],
                        ['question' => 'È possibile ottenere l\'ammissione alle scuole superiori?', 'answer' => 'Sì, supportiamo le domande per istituti secondari europei e programmi di mobilità studentesca.'],
                        ['question' => 'I requisiti cambiano da paese a paese?', 'answer' => 'Sì, variano in base all\'ordinamento scolastico nazionale e guidiamo ogni singolo passaggio.'],
                        ['question' => 'Si può fare domanda a più atenei?', 'answer' => 'Sì, consigliamo di presentare più candidature per massimizzare le probabilità di successo.'],
                        ['question' => 'L\'ammissione è garantita?', 'answer' => 'La decisione finale appartiene all\'istituto; noi garantiamo una domanda ineccepibile e conforme.'],
                    ],
                ],
                'badge' => ['ar' => 'قبول جامعي وثانوي', 'en' => 'University & School Admission', 'it' => 'Ammissione Accademica'],
                'category_label' => ['ar' => 'الدراسة والجامعات', 'en' => 'Study & Universities', 'it' => 'Studi Universitari'],
            ],

            // 09. خدمة التدقيق اللغوي
            [
                'slug_ar' => 'proofreading-service',
                'slug_en' => 'proofreading-service',
                'slug_it' => 'revisione-linguistica',
                'title' => [
                    'ar' => 'خدمة التدقيق اللغوي',
                    'en' => 'Linguistic Proofreading Service',
                    'it' => 'Servizio di Revisione Linguistica',
                ],
                'headline' => [
                    'ar' => 'خلي كتاباتك أكثر دقة واحترافية',
                    'en' => 'Make Your Writing More Accurate & Professional',
                    'it' => 'Rendi i Tuoi Testi Più Precisi e Professionali',
                ],
                'summary' => [
                    'ar' => 'خدمة مراجعة وتدقيق النصوص والمستندات لغويًا، بهدف تحسين جودة الكتابة وتصحيح الأخطاء الإملائية والنحوية وعلامات الترقيم، مع الحفاظ على المعنى الأصلي للنص.',
                    'en' => 'Comprehensive editing and proofreading of academic, literary, and corporate texts, eliminating grammatical errors while preserving original core meaning.',
                    'it' => 'Revisione e correzione di testi e documenti per elevare lo stile, correggere errori ortografici e grammaticali mantenendo il senso originario.',
                ],
                'description' => [
                    'ar' => 'خدمة مراجعة وتدقيق النصوص والمستندات لغويًا، بهدف تحسين جودة الكتابة وتصحيح الأخطاء الإملائية والنحوية وعلامات الترقيم، مع الحفاظ على المعنى الأصلي للنص.',
                    'en' => 'Comprehensive editing and proofreading of academic, literary, and corporate texts, eliminating grammatical errors while preserving original core meaning.',
                    'it' => 'Revisione e correzione di testi e documenti per elevare lo stile, correggere errori ortografici e grammaticali mantenendo il senso originario.',
                ],
                'features' => [
                    'ar' => [
                        'مراجعة الأخطاء الإملائية والنحوية.',
                        'تحسين الصياغة والأسلوب.',
                        'ضبط علامات الترقيم.',
                        'توحيد المصطلحات والتنسيق.',
                        'مراجعة الأبحاث والمستندات الأكاديمية.',
                        'الحفاظ على المعنى الأصلي للنص.',
                    ],
                    'en' => [
                        'Correction of spelling, syntactic, and grammatical errors.',
                        'Enhancing sentence flow, vocabulary richness, and academic style.',
                        'Punctuation and typography standardization.',
                        'Harmonization of specialized terminology and formatting.',
                        'Proofreading research papers, theses, and admissions letters.',
                        'Preserving author voice and original nuances intact.',
                    ],
                    'it' => [
                        'Correzione di refusi ortografici, sintassi e grammatica.',
                        'Perfezionamento dello stile e della fluidità espositiva.',
                        'Cura della punteggiatura e delle norme editoriali.',
                        'Uniformazione della terminologia specialistica.',
                        'Revisione di tesi di laurea, saggi e documenti accademici.',
                        'Rispetto assoluto del significato e del tono originale.',
                    ],
                ],
                'requirements' => [
                    'ar' => [
                        'إرسال الملف المراد تدقيقه.',
                        'تحديد لغة النص.',
                        'تحديد نوع التدقيق المطلوب.',
                        'توضيح الموعد المطلوب للتسليم.',
                    ],
                    'en' => [
                        'Upload or submit document to be proofread.',
                        'Specify language of the manuscript.',
                        'Define scope of editing required (light proofread vs. deep copy-editing).',
                        'State required delivery timeline.',
                    ],
                    'it' => [
                        'Invio del documento da revisionare.',
                        'Indicazione della lingua del testo.',
                        'Tipologia di revisione desiderata (correzione bozze o editing stilistico).',
                        'Termine di consegna richiesto.',
                    ],
                ],
                'steps' => [
                    'ar' => [
                        'استلام الملف ومراجعته.',
                        'تحديد نطاق التدقيق والتكلفة.',
                        'تنفيذ التدقيق والمراجعة.',
                        'تسليم الملف بعد التعديل.',
                    ],
                    'en' => [
                        'File reception and initial diagnostic scan.',
                        'Scope, word count, and quote confirmation.',
                        'Linguistic proofreading by domain editors.',
                        'Final delivery with tracked and clean copy files.',
                    ],
                    'it' => [
                        'Ricezione e lettura preliminare del testo.',
                        'Definizione del preventivo in base al conteggio parole.',
                        'Esecuzione della revisione da parte di un linguista specializzato.',
                        'Consegna del documento revisionato (con modifiche tracciate e pulito).',
                    ],
                ],
                'faqs' => [
                    'ar' => [
                        ['question' => 'هل يتم التدقيق باللغة العربية والإنجليزية؟', 'answer' => 'نعم، نوفر التدقيق اللغوي باللغات العربية، الإنجليزية، الإيطالية، ولغات أخرى بإشراف مدققين لغويين متخصصين.'],
                        ['question' => 'هل تشمل الخدمة إعادة الصياغة؟', 'answer' => 'نعم، يمكن طلب إعادة صياغة أكاديمية أو أسلوبية لتحسين السلاسة وقوة التعبير مع الحفاظ الدقيق على المعنى الأصلي.'],
                        ['question' => 'هل يمكن تدقيق الأبحاث العلمية؟', 'answer' => 'نعم، نراجع أطروحات الماجستير والدكتوراه، الأوراق البحثية، رسائل التحفيز (Motivation Letters)، والسير الذاتية الأكاديمية.'],
                        ['question' => 'هل يتم الحفاظ على تنسيق الملف؟', 'answer' => 'نعم، نلتزم بتسليم الملف بنفس التنسيق والجداول والتخطيط الأصلي (Word أو PDF) مع إمكانية توفير نسخة تتضمن التعديلات المتتبعة (Track Changes).'],
                        ['question' => 'ما مدة تنفيذ الخدمة؟', 'answer' => 'يتم تحديد المدة بدقة بناءً على عدد الكلمات وطبيعة النص، ونوفر خدمة التدقيق السريع للحالات العاجلة.'],
                    ],
                    'en' => [
                        ['question' => 'Is proofreading available in Arabic, English, and Italian?', 'answer' => 'Yes, we provide proofreading in Arabic, English, Italian, and other languages by qualified native linguists.'],
                        ['question' => 'Does it include stylistic rewriting?', 'answer' => 'Yes, advanced stylistic and academic rewriting is available upon request.'],
                        ['question' => 'Can scientific and PhD research papers be reviewed?', 'answer' => 'Yes, we edit masters theses, doctoral dissertations, research journals, and motivation letters.'],
                        ['question' => 'Is original file layout maintained?', 'answer' => 'Yes, layouts and tables are preserved, and a Track Changes copy is delivered.'],
                        ['question' => 'What is the turnaround time?', 'answer' => 'Turnaround depends on word count; express turnaround is available for urgent needs.'],
                    ],
                    'it' => [
                        ['question' => 'La revisione è disponibile in arabo, inglese e italiano?', 'answer' => 'Sì, effettuiamo revisioni in arabo, inglese, italiano e altre lingue con revisori madrelingua.'],
                        ['question' => 'Include la riscrittura stilistica?', 'answer' => 'Sì, è possibile richiedere interventi di riscrittura accademica per migliorare l\'efficacia espositiva.'],
                        ['question' => 'È possibile revisionare tesi e paper scientifici?', 'answer' => 'Certamente, revisioniamo tesi di laurea, pubblicazioni scientifiche e lettere motivazionali.'],
                        ['question' => 'Viene mantenuta l\'impaginazione originale?', 'answer' => 'Sì, preserviamo formattazione e tabelle, fornendo il file con revisioni tracciate.'],
                        ['question' => 'Quali sono i tempi di consegna?', 'answer' => 'I tempi dipendono dalla lunghezza del testo, con servizio rapido per urgenze.'],
                    ],
                ],
                'badge' => ['ar' => 'دقة وجودة أكاديمية', 'en' => 'Academic Quality', 'it' => 'Qualità Accademica'],
                'category_label' => ['ar' => 'التدقيق اللغوي والتحرير', 'en' => 'Proofreading & Editing', 'it' => 'Revisione & Editing'],
            ],

            // 10. حجز مواعيد السفارات والقنصليات
            [
                'slug_ar' => 'embassy-appointments',
                'slug_en' => 'embassy-appointments',
                'slug_it' => 'appuntamenti-ambasciate-consolati',
                'title' => [
                    'ar' => 'حجز مواعيد السفارات والقنصليات',
                    'en' => 'Embassy & Consulate Appointments',
                    'it' => 'Prenotazione Appuntamenti Consolari',
                ],
                'headline' => [
                    'ar' => 'تسهيل ومتابعة إجراءات حجز المواعيد الرسمية',
                    'en' => 'Streamlined Booking & Follow-up for Consular Appointments',
                    'it' => 'Supporto e Monitoraggio Appuntamenti Consolari Ufficiali',
                ],
                'summary' => [
                    'ar' => 'نقدم المساعدة في إجراءات حجز مواعيد السفارات والقنصليات وفق الأنظمة والمتطلبات المتاحة لكل جهة، مع توضيح خطوات الحجز والمعلومات اللازمة لإتمام الطلب.',
                    'en' => 'Assistance with embassy and consulate booking procedures per available official platforms, clarifying required steps and documentation.',
                    'it' => 'Assistenza nelle procedure di prenotazione appuntamenti presso ambasciate e consolati, con indicazione di requisiti e modulistica.',
                ],
                'description' => [
                    'ar' => 'نقدم المساعدة في إجراءات حجز مواعيد السفارات والقنصليات وفق الأنظمة والمتطلبات المتاحة لكل جهة، مع توضيح خطوات الحجز والمعلومات اللازمة لإتمام الطلب. (تنويه: الخدمة خاصة بالمساعدة في حجز المواعيد، ولا تشمل إصدار التأشيرات أو ضمان الحصول عليها).',
                    'en' => 'Guidance on booking consular appointments per official diplomatic portals, requirements explanation, and status tracking. (Note: Service covers booking assistance and does not guarantee or issue visas).',
                    'it' => 'Supporto nell\'orientamento sui portali consolari per fissare appuntamenti, con chiarimenti documentali. (Avvertenza: il servizio riguarda l\'assistenza alla prenotazione e non garantisce il rilascio del visto).',
                ],
                'features' => [
                    'ar' => [
                        'متابعة مواعيد السفارات والقنصليات الرسمية.',
                        'إرشاد كامل حول المستندات المطلوبة للمقابلة.',
                        'تعبئة نماذج الطلبات بدقة لتجنب الأخطاء.',
                        'توضيح رسوم الحجز والإجراءات المعتمدة.',
                    ],
                    'en' => [
                        'Monitoring available consular and diplomatic appointment slots.',
                        'Full guidance on required checklist of interview documents.',
                        'Accurate completion of visa and consular application forms.',
                        'Clear breakdown of official fees and approved submission pathways.',
                    ],
                    'it' => [
                        'Monitoraggio costante degli slot per appuntamenti consolari.',
                        'Guida completa sui documenti da presentare al colloquio.',
                        'Compilazione accurata dei formulari per evitare errori.',
                        'Chiarimenti sui diritti consolari e sulle procedure ufficiali.',
                    ],
                ],
                'requirements' => [
                    'ar' => [
                        'جواز سفر ساري المفعول.',
                        'تحديد الغرض من السفر (دراسة، عمل، سياحة).',
                        'تحديد السفارة والقنصلية المطلوب التقديم عليها.',
                    ],
                    'en' => [
                        'Valid passport.',
                        'Clear travel purpose (study, employment, tourism).',
                        'Target embassy or consulate specified.',
                    ],
                    'it' => [
                        'Passaporto valido.',
                        'Motivo del viaggio (studio, lavoro, turismo).',
                        'Indicazione del consolato o ambasciata competente.',
                    ],
                ],
                'steps' => [
                    'ar' => [
                        'مراجعة بيانات جواز السفر والغرض.',
                        'تجهيز نموذج الموعد ومتطلبات الحجز.',
                        'حجز الموعد ومتابعة تأكيده.',
                        'تسليم إشعار الموعد وقائمة المستندات.',
                    ],
                    'en' => [
                        'Review passport details and travel reason.',
                        'Prepare appointment booking profile and documents.',
                        'Schedule slot and monitor confirmation issuance.',
                        'Deliver confirmation receipt and checklist.',
                    ],
                    'it' => [
                        'Verifica dei dati del passaporto e delle finalità.',
                        'Preparazione del profilo di prenotazione.',
                        'Fissazione dell\'appuntamento e conferma.',
                        'Rilascio della ricevuta e promemoria documenti.',
                    ],
                ],
                'faqs' => [
                    'ar' => [
                        ['question' => 'هل تضمن الخدمة إصدار التأشيرة؟', 'answer' => 'الخدمة مخصصة للمساعدة في حجز المواعيد وتجهيز الملفات، وإصدار التأشيرة هو قرار سيادي حصري للجهة القنصلية.'],
                        ['question' => 'ما السفارات التي يتم المساعدة في حجز مواعيدها؟', 'answer' => 'نوفر المساعدة في حجز مواعيد سفارات وقنصليات الدول الأوروبية وغيرها وفق ما تتيحه البوابات الرسمية.'],
                    ],
                    'en' => [
                        ['question' => 'Does this service guarantee a visa?', 'answer' => 'No, the service provides appointment booking assistance; visa issuance is the exclusive sovereign decision of the consulate.'],
                        ['question' => 'Which embassies are supported?', 'answer' => 'We assist with European embassies and consulates based on official availability.'],
                    ],
                    'it' => [
                        ['question' => 'Il servizio garantisce il visto?', 'answer' => 'No, forniamo assistenza per l\'appuntamento; il rilascio del visto spetta solo all\'autorità consolare.'],
                        ['question' => 'Per quali ambasciate è attivo il servizio?', 'answer' => 'Supportiamo le prenotazioni per le rappresentanze diplomatiche dei paesi europei.'],
                    ],
                ],
                'badge' => ['ar' => 'متابعة رسمية وفق المواعيد', 'en' => 'Official Booking Assistance', 'it' => 'Assistenza Ufficiale'],
                'category_label' => ['ar' => 'المواعيد القنصلية والدبلوماسية', 'en' => 'Consular & Diplomatic Appointments', 'it' => 'Servizi Consolari & Appuntamenti'],
            ],
        ];

        foreach ($servicesData as $data) {
            $service = Service::query()->where('slug_ar', $data['slug_ar'])->first();

            $updatePayload = [
                'slug_en' => $data['slug_en'],
                'slug_it' => $data['slug_it'],
                'slug' => [
                    'ar' => $data['slug_ar'],
                    'en' => $data['slug_en'],
                    'it' => $data['slug_it'],
                ],
                'title' => $data['title'],
                'headline' => $data['headline'],
                'summary' => $data['summary'],
                'description' => $data['description'],
                'features' => $data['features'],
                'requirements' => $data['requirements'],
                'steps' => $data['steps'],
                'faqs' => $data['faqs'],
                'badge' => $data['badge'],
                'category_label' => $data['category_label'],
                'seo_title' => [
                    'ar' => $data['headline']['ar'] . ' | أكاديمية INTOK',
                    'en' => $data['headline']['en'] . ' | INTOK Academy',
                    'it' => $data['headline']['it'] . ' | INTOK Academy',
                ],
                'seo_description' => $data['summary'],
                'is_active' => true,
            ];

            if ($service) {
                $service->update($updatePayload);
            } else {
                Service::query()->create($updatePayload + [
                    'slug_ar' => $data['slug_ar'],
                    'icon' => 'documents',
                    'sort_order' => 1,
                ]);
            }
        }

        Cache::forget('site.services.active');
        Cache::forget('site.sitemap');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Cache::forget('site.services.active');
        Cache::forget('site.sitemap');
    }
};
