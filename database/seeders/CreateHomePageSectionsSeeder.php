<?php

namespace Database\Seeders;

use App\Models\HomePageSection;
use Illuminate\Database\Seeder;

class CreateHomePageSectionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HomePageSection::create([
            'title_en' => 'Hero Section',
            'title_ar' => 'الصفحه الرئيسيه',
            'description_en' => 'Welcome to our website! We are delighted to have you here. Explore our services and offerings designed to meet your needs.',
            'description_ar' => 'مرحبًا بكم في موقعنا! نحن سعداء بوجودك هنا. استكشف خدماتنا وعروضنا المصممة لتلبية احتياجاتك.',
            'type' => 'hero',
            'order' => 1,
            'is_active' => true,
        ]);

        HomePageSection::create([
            'title_en' => 'About Us Section',
            'title_ar' => 'من نحن',
            'description_en' => 'We are a team of dedicated professionals committed to delivering top-notch solutions. Our mission is to exceed your expectations and provide exceptional value.',
            'description_ar' => 'نحن فريق من المحترفين المكرسين ملتزمون بتقديم حلول عالية الجودة. مهمتنا هي تجاوز توقعاتك وتقديم قيمة استثنائية.',
            'type' => 'about_us',
            'order' => 2,
            'is_active' => true,
        ]);

        HomePageSection::create([
            'title_en' => 'Featured Projects Section',
            'title_ar' => 'مشاريع مميزة',
            'description_en' => 'Discover our featured projects that showcase our expertise and innovation. Each project is a testament to our commitment to excellence.',
            'description_ar' => 'اكتشف مشاريعنا المميزة التي تعرض خبرتنا وابتكارنا. كل مشروع هو شهادة على التزامنا بالتميز.',
            'type' => 'featured_projects',
            'order' => 3,
            'is_active' => true,
        ]);

        HomePageSection::create([
            'title_en' => 'Partners Section',
            'title_ar' => 'شركاء',
            'description_en' => 'We collaborate with industry-leading partners to bring you the best solutions. Our partnerships are built on trust, innovation, and shared success.',
            'description_ar' => 'نتعاون مع شركاء رائدين في الصناعة لنقدم لك أفضل الحلول. تستند شراكاتنا إلى الثقة والابتكار والنجاح المشترك.',
            'type' => 'partners',
            'order' => 4,
            'is_active' => true,
        ]);

        HomePageSection::create([
            'title_en' => 'News Section',
            'title_ar' => 'الأخبار',
            'description_en' => 'Stay updated with the latest news and insights from our industry. Our news section provides valuable information to keep you informed.',
            'description_ar' => 'ابقَ على اطلاع بأحدث الأخبار والرؤى من صناعتنا. يوفر قسم الأخبار لدينا معلومات قيمة لإبقائك على اطلاع.',
            'type' => 'news',
            'order' => 5,
            'is_active' => true,
        ]);

        HomePageSection::create([
            'title_en' => 'Contact Us Section',
            'title_ar' => 'تواصل معنا',
            'description_en' => 'We would love to hear from you! Whether you have questions, feedback, or inquiries, our team is here to assist you. Reach out to us anytime.',
            'description_ar' => 'نود أن نسمع منك! سواء كانت لديك أسئلة أو ملاحظات أو استفسارات، فإن فريقنا هنا لمساعدتك. تواصل معنا في أي وقت.',
            'type' => 'contact_us',
            'order' => 6,
            'is_active' => true,
        ]);
        
    }
}
