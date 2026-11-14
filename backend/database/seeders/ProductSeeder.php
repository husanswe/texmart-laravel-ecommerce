<?php

namespace Database\Seeders;

use App\Models\AttributeValue;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Fetch categories and brands by slug/name — never hardcode ids
        $smartphonesCat = Category::where('slug', 'smartfonlar')->first();
        $xiaomiBrand = Brand::where('slug', 'xiaomi')->first();
        $laptopsCat = Category::where('slug', 'noutbuklar')->first();
        $asusBrand = Brand::where('slug', 'asus')->first();
        $SamsungBrand = Brand::where('slug', 'samsung')->first();

        $appleBrand = Brand::where('slug', 'apple')->first();
        $ram8 = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'ram'))->where('value', '8')->first();
        $ram12 = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'ram'))->where('value', '12')->first();
        $storage128 = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'storage'))->where('value', '128')->first();
        $colorWhite = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'color'))->where('value', 'White')->first();
        
        $tvsCat = Category::where('slug', 'televizorlar')->first();
        $artelBrand = Brand::where('slug', 'artel')->first();
        $LgBrand = Brand::where('slug', 'lg')->first();

        $fridgesCat = Category::where('slug', 'sovutgichlar')->first();
        $boschBrand = Brand::where('slug', 'bosch')->first();

        $washingMachineCat = Category::where('slug', 'kir-yuvish-mashinalari')->first();
        $toshibaBrand = Brand::where('slug', 'toshiba')->first();
        $hisenseBrand = Brand::where('slug', 'hisense')->first();
        $acCat = Category::where('slug', 'air-conditioner')->first();

        $SmallAppliancesCat = Category::where('slug', 'uy-uchun-kichik-texnika')->first();
        $BraunBrand = Brand::where('slug', 'braun')->first();
        $PhilipsBrand = Brand::where('slug', 'philips')->first();
        $TefalBrand = Brand::where('slug', 'tefal')->first();
        $PolarisBrand = Brand::where('slug', 'polaris')->first();

        $screen55 = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'screen-size'))->where('value', '55')->first();
        $res4k = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'resolution'))->where('value', '4K')->first();

        $ram16 = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'ram'))->where('value', '16')->first();
        $storage512 = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'storage'))->where('value', '512')->first();
        $colorSilver = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'color'))->where('value', 'Silver')->first();
        $hpBrand = Brand::where('slug', 'hp')->first();


        // Fetching attribute values i'll attach
        $storage256 = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'storage'))->where('value', '256')->first();
        $colorBlack = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'color'))->where('value', 'Black')->first();
        $colorBlue = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'color'))->where('value', 'Blue')->first();
        $colorRed = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'color'))->where('value', 'Red')->first();

        // Creating product - Phone
        $redmi = Product::create([
            'category_id' => $smartphonesCat->id,
            'brand_id' => $xiaomiBrand->id,
            'name' => 'Xiaomi Redmi 15C',
            'slug' => 'xiaomi-redmi-15c',
            'price' => 2399000,
            'description' => "Xiaomi Redmi 15C (8/256 GB) — Xiaomi HyperOS 2 (Android 15 asosida) operatsion tizimida ishlovchi, 
                zamonaviy va yuqori avtonomlikka ega smartfon. Qurilma 120 Hz yangilanish tezligi, 810 nit yorqinlik va Wet Touch Technology 2.0 
                texnologiyasiga ega keng 6.9 dyuymli HD+ (1600 × 720) IPS LCD ekran bilan jihozlangan.
                Unumdorlik uchun 8 yadroli MediaTek Helio G81-Ultra protsessori va Mali-G52 MC2 grafik tezlatkichi javob beradi. 
                8 GB LPDDR4X tezkor xotira (virtual xotira hisobiga 16 GB gacha kengaytirish mumkin) hamda 256 GB ichki xotira 
                (microSD orqali 1 TB gacha kengaytiriladi) tizim va ilovalarning tezkor ishlashini ta'minlaydi. 50 MP asosiy kamera va 
                8 MP old kamera Full HD (1080p@30fps) sifatida video yozib olish imkonini beradi.
                Smartfon 33 Vt tezkor quvvatlash va 10 Vt teskari quvvatlash (reverse charging) funksiyalarini qo'llab-quvvatlovchi 
                6000 mA/s sig'imli katta akkumulyatorga ega. Korpus IP64 standarti bo'yicha chang va suv sachrashidan himoyalangan bo'lib, 
                yon tarafdagi barmoq izi skaneri, NFC, Bluetooth 5.4, 3.5 mm audio raz'em hamda Dual SIM uyasi bilan to'ldirilgan.",
        ]);

        ProductVariant::create([
            'product_id' => $redmi->id,
            'name' => '8/256 Midnight Black',
            'sku' => 'RDM15C-8-256-BLK',
            'price' => 2399000,
            'stock' => 20,
        ]);

        // 4. Attaching attribute values via pivot
        $redmi->attributeValue()->attach([
            $ram8->id,
            $storage256->id,
            $colorBlack->id
        ]);

        $galaxyA56 = Product::create([
            'category_id' => $smartphonesCat->id,
            'brand_id' => $SamsungBrand->id,
            'name' => 'Samsung Galaxy A56 5G',
            'slug' => 'samsung-galaxy-a56-5g',
            'price' => 4299000,
            'description' => 'Samsung Galaxy A56 5G — zamonaviy dizayn va kuchli kamera. Samsung Galaxy A56 8/128 Gray smartfoni - kundalik vazifalar va ko‘ngilxushliklar uchun zamonaviy va samarali smartfon. Zamonaviy texnologiyalar, nafis dizayn va ajoyib samaradorlikni o‘zida mujassam etgan holda, u har qanday vaziyatda ishonchli yordamchingizga aylanadi.

            Samsung Galaxy A56 xususiyatlari:

            Ekran: 6.7 dyuymli Super AMOLED displey videolar, o‘yinlar va ishlash uchun yorqin va to‘yingan ranglarga ega.
            Unumdorlik: 8 GB tezkor xotira va 128 GB ichki xotira fayllar, suratlar va ilovalarni saqlash uchun. Kuchli protsessor qurilmaning kechikishlarsiz tez ishlashini ta’minlaydi.
            Kamera: Sifatli suratlar va video qo‘ng‘iroqlar uchun 50 MP asosiy va 12 MP old kamera.
            Akkumulyator: 5000 mA/soat quvvatga ega batareya, tez zaryadlashni qo‘llab-quvvatlaydi va uzoq vaqt davomida qayta zaryadlamasdan foydalanish imkonini beradi.
            Dizayn: Qo‘lda qulay turadigan ingichka ramkali zamonaviy va didli kulrang korpus.
            Afzalliklari:

            Kontentni qulay qabul qilish uchun ajoyib displey.
            Kuchli protsessor va ravon ishlash uchun dasturiy ta’minotni optimallashtirish.
            Katta sig‘imli batareya tufayli uzoq muddatli avtonomlik.
            Har qanday sharoitda suratga olish uchun ajoyib kameralar.',
        ]);

        ProductVariant::create([
            'product_id' => $galaxyA56->id,
            'name' => '8/256 Black',
            'sku' => 'SAM-A56-8-256-BLK',
            'price' => 4299000,
            'stock' => 20,
        ]);

        ProductVariant::create([
            'product_id' => $galaxyA56->id,
            'name' => '8/256 Blue',
            'sku' => 'SAM-A56-8-256-BLU',
            'price' => 4299000,
            'stock' => 12,
        ]);

        $galaxyA56->attributeValue()->attach([
            $ram8->id,
            $storage256->id,
            $colorBlack->id,
        ]);

        // iPhones
        $iphone16Pro = Product::create([
            'category_id' => $smartphonesCat->id,
            'brand_id' => $appleBrand->id,
            'name' => 'Apple iPhone 16 Pro 8/128 GB',
            'slug' => 'apple-iphone-16-pro',
            'price' => 14999000,
            'description' => 'iPhone 16 Pro – siz ko‘proq yutuqlarga erishishingiz uchun yaratilgan qurilmadir. Texnologiya sohasidagi eng so‘nggi kashfiyotlar va puxta ishlab chiqilgan dizayn uning peshqadamligini ta’minlaydi.
            Apple Intelligence 
            Intelligence’ning eng yangi versiyasi bilan smartfoningiz nafaqat noyob vositaga, balki ishonchli hamkoriga aylanadi. Tizim kundalik vazifalarni yengillashtirish, ularni soddalashtirish va shu bilan birga ma’lumotlar himoyasini kafolatlash uchun mo‘ljallangan. Ma’lumotlarning maxfiyligini ta’minlash maqsadida har bir jarayon bevosita qurilmada ishlov beriladi, bu esa ma’lumotlarning chiqib ketish xavfini istisno qiladi. Endi telefoningiz sizni yanada yaxshiroq tushunadi va sizning xohish-istaklaringizga asoslangan yechimlarni taklif qiladi.
            Xavfsizlik
            Maxfiylik tushunchasi yangi Private Cloud Compute bilan qayta ko‘rib chiqildi. Serverlar yordamida ma’lumotlarga ishlov berish maxfiylikka murosasiz resurs talab qiladigan vazifalarni bajarish imkonini beradi. Xavfsizlik va samaradorlikning bunday noyob uyg‘unligi hatto eng murakkab vazifalarni ham hal qilish imkonini beradi.
            Kameralar
            48 MP Fusion va avtofokusli ultra keng obyektivni o‘z ichiga olgan qudratli ikki kamerali tizim tufayli tasvirlaringiz yangi darajaga yetadi. Apple Vision orqali fazoviy 3D ko‘rinishga tayyor fotosuratlar yarating, shuningdek, eng mayda tafsilotlarni aks ettirish uchun makrosyomka bilan tajriba o‘tkazing. Camera Control yordamida kamera sozlamalari yanada oson va qulay bo‘ladi, bu esa professional darajadagi suratlarni tez va oson olish imkonini beradi.
            Mukammal ovoz
            Ovoz vizual kontentdan qolishmaydi, shuning uchun qurilma Audio Mix funksiyasi bilan jihozlangan. U ortiqcha fonni olib tashlab, kerakli lahzalarda ovoz yoki urg‘ularni kuchaytirish orqali videoni sozlash imkonini beradi. Makoniy ovoz va sun’iy intellekt har bir rolikni to‘laqonli kinoga aylantiradi.
            Unumdorlik
            Kuchli A18Pro protsessori asosiy markazga aylandi. U olti yadroli arxitektura bilan jihozlangan bo‘lib, ikkita yuqori unumli va to‘rtta energiya tejamkor yadrodan iborat, bu esa mukammal quvvat muvozanatini ta’minlaydi. Shuningdek, olti yadroli A18GPU grafik chipi ham mavjud bo‘lib, u vizual samaradorlikni yangi bosqichga ko‘taradi hamda o‘yinlar va videolardan maksimal aniqlik va ravonlik bilan zavqlanish imkonini beradi.
            Xotira
            8 GB operativ xotiraga ega bo‘lib, ko‘p vazifalarni tez va ravon bajarishni ta’minlaydi, shuningdek 128 GB ichki xotira turli xil fayllar uchun yetarli joy beradi.
            Energiya sig‘imi
            3355 mA⋅soat sig‘imli akkumulyator uzoq vaqt mustaqil ishlash uchun moslashtirilgan. Energiya samaradorligi va tizimning optimallashtirish tufayli qurilma zaryadlanmasdan 27 soatgacha video kontent ko‘rsatish qobiliyatiga ega.',
        ]);

        ProductVariant::create([
            'product_id' => $iphone16Pro->id,
            'name' => '8/128 White',
            'sku' => 'APL-IP16-8-128-WHT',
            'price' => 14999000,
            'stock' => 20,
        ]);

        ProductVariant::create([
            'product_id' => $iphone16Pro->id,
            'name' => '8/256 Black',
            'sku' => 'APL-IP16-8-256-BLK',
            'price' => 16999000,
            'stock' => 20,
        ]);

        $iphone16Pro->attributeValue()->attach([
            $ram8->id,
            $storage128->id,
            $colorWhite->id,
        ]);


        // iPhone 17 Pro
        $iphone17Pro = Product::create([
            'category_id' => $smartphonesCat->id,
            'brand_id' => $appleBrand->id,
            'name' => 'Apple iPhone 17 Pro 12/256 GB',
            'slug' => 'apple-iphone-17-pro-12-256gb',
            'price' => 18000000,
            'description' => 'iPhone 17 Pro - yangi texnologiyalar avlodiga qadam
                Apple o‘zining yetakchiligini iPhone 17 Pro - nafis dizayn, yuqori unumdorlik va aqlli yechimlar uyg‘unligini taqdim etish orqali tasdiqlamoqda. Alyuminiy va toblangan shishadan tayyorlangan mustahkam korpus nafaqat ishonchlilikni, balki premium ko‘rinishni ham ta’minlaydi. 206 gramm og‘irlik qurilmani kundalik foydalanish uchun yengil va qulay qiladi, yangi iOS 26 esa moslashtirish va ekotizimga integratsiya qilishning qo‘shimcha imkoniyatlarini ochadi. Bunday smartfon ham ish, ham ijod uchun ajoyib tanlov bo‘lib, maqomi va amaliyligini saqlab qoladi.
                Super Retina XDR ekrani - tasvir sehri
                Yangi 6,3 dyuymli panel o‘zining to‘yinganligi va batafsilligi bilan hayratda qoldiradi. 2622x1206 piksellar o‘lchami 460 PPI zichligida eng kichik tafsilotlarni ham ko‘rish imkonini beradi va 120 Gs yangilanish chastotasi animatsiyani iloji boricha ravon ko‘rsatadi. Tomonlar nisbati 19.5:9 filmlar va o‘yinlarni tomosha qilishda kinematografik effekt yaratadi. Bundan tashqari, sirtni tirnalish va tushishdan himoya qiluvchi Ceramic Shield 2 ishlatiladi. Yorug‘likni avtomatik sozlash har qanday yorug‘lik sharoitida tasvirning tabiiyligini saqlab qoladi.
                A19 Pro protsessor quvvati
                Qurilma 3 nm texnologik jarayonda yaratilgan eng yangi A19 chipi asosida ishlaydi. Yuqori energiya samaradorligi va olti yadroli arxitektura foydalanuvchining har qanday harakatiga darhol javob berishni osonlashtiradi. 12 GB tezkor xotira tufayli ko‘p resurs talab qiladigan ilovalar bilan ishlash va bir vaqtning o‘zida bir nechta jarayonlarni muammosiz bajarish mumkin. Ichki 256 GB xotira filmlar, musiqa va o‘yinlar to‘plami uchun yetarli. Xotira kartasi uchun slot mavjud emas, bu iCloud bulutli xizmati bilan integratsiya va ma’lumotlar xavfsizligiga urg‘u beradi.
                Avtonomlik va tezkor quvvatlash
                4252 mA/soat sig‘imli batareya kun davomida ishonchli ishlashni kafolatlaydi. Smartfon hatto intensiv ishlatilganda ham barqaror avtonomlik ko‘rsatkichlarini namoyish etadi. Tezlashtirilgan quvvatlashni qo‘llab-quvvatlash energiya zaxirasini minimal vaqt ichida to‘ldirish imkonini beradi, bu ayniqsa yo‘lda yoki ishbilarmonlik uchrashuvlari paytida juda muhimdir. USB Type-C ulagichi ulanish jarayonini universal va ko‘plab aksessuarlar bilan moslashtiradi. Shu tufayli gadjet har qanday ssenariyda - ishdan sayohatgacha dolzarb bo‘lib qoladi.
                Kommunikatsiya va multimedia
                Gadjet zamonaviy aloqa standartlarini qo‘llab-quvvatlaydi: LTE va 5G barqaror ulanish va yuqori ma’lumot uzatish tezligini ta’minlaydi. Simsiz ulanish uchun yangi avlod Wi-Fi va Bluetooth 6.0 mavjud. NFCga kirish xavfsiz to‘lovlarni amalga oshirish imkonini beradi va USB Type-C ulagichining mavjudligi simli quloqchinlar yoki tashqi xotiralardan foydalanish imkonini beradi. Bunday kombinatsiya modelni ko‘ngilochar, ishbilarmonlik qo‘ng‘iroqlari va onlayn muloqot uchun universal qiladi.
                Himoya va ishonchlilik
                IP68 ning suv va changdan himoyalanganlik darajasi qurilmaning turli sharoitlarda saqlanishiga yordam beradi. Gadjet funksiyalar ishlashiga zarar yetkazmagan holda namlik va chang bilan aloqaga bardosh beradi. Apple muhandislari kompaniya egasi har qanday sharoitda o‘zini ishonchli his qilishi uchun har bir detalni puxta o‘ylab chiqishgan. 17 Pro shunchaki vosita emas, balki dizayn, unumdorlik va qulaylikni yagona yechimda mujassamlashtirgan ishonchli hamrohga aylanmoqda.',
        ]);

        ProductVariant::create([
            'product_id' => $iphone17Pro->id,
            'name' => '12/256 Deep Blue',
            'sku' => 'APL-IP17-12-256-DBL',
            'price' => 18000000,
            'stock' => 50,
        ]);

        $iphone17Pro->attributeValue()->attach([
            $ram12->id,
            $storage256->id,
            $colorBlue->id,
        ]);

        // iPhone 18 Pro
        $iphone18Pro256 = Product::create([
            'category_id' => $smartphonesCat->id,
            'brand_id' => $appleBrand->id,
            'name' => 'Apple iPhone 18 Pro 12/256 GB',
            'slug' => 'apple-iphone-18-pro-12-256gb',
            'price' => 19000000,
            'description' => 'Diqqatni tortadigan displey
                Apple iPhone 18 Pro 6,3 dyuymli Super Retina XDR ekrani bilan jihozlangan bölib, uning ölçami 2622x1206 va ziçligi 460 PPI. Har bir detal aniq körinadi, ranglar esa jonli va tabiiy tarzda beriladi. 120 Gs yangilaniş çastotasi tasmalarni aylantiriş, ilovalararo ötiş va öyin sahnalarini hayratlanarli darajada ravon qiladi. Ceramic Shield 2 şişasi yuzani tirnaliş va tasodifiy zarbalardan işonçli himoya qiladi, şuning uçun smartfon özining asl körinişini uzoqroq vaqt saqlaydi.
                Yangi avlod protsessori
                Qurilmaning yuragi 2 nanometrli texnologik jarayon asosida yaratilgan A20 Pro çipidir. Oltita yadro oğir öyinlarni, video montajni va bir vaqtning özida köplab dasturlarni keçikişlarsiz va qizib ketmasdan boşqaradi. 12 GB operativ xotira vazifalar örtasida tezkor almaşişni ta’minlaydi, 256 GB xotira esa minglab rasmlar, videolar, musiqa va sevimli ilovalarni öz içiga oladi. IOS 27 operatsion tizimi buni tezkor, puxta öylangan va xavfsiz muhit bilan töldiradi.
                Yorqin kadrlar uçun kameralar
                Har bir moduli 48 MP aniqlik darajasiga ega bölgan uçta asosiy kamera keng kölamli manzaralar, portretlar va detallarni yuqori aniqlik bilan yirik planda suratga oliş imkonini beradi. Suratlar hatto past yoruğlikda ham aniq çiqadi, video esa professional darajada körinadi. 18 megapikselli old kamera ajoyib selfilarni yaratadi va qarindoşlar, döstlar, hamkasblar bilan video qönğiroqlar paytida sifatli tasvirni ta’minlaydi.
                Avtonomlik va tez quvvatlaş
                4056 mA·soat siğimli akkumulyator kun davomida işonçli işlaşni ta’minlaydi: yozişmalar, navigatsiya, suratlar, strimlar. Quvvat tugagaç, USB Type-C ulagiçi orqali tezkor quvvatlaş funksiyasi qisqa vaqt içida quvvatni qaytaradi. Xuddi şu port quloqçinlar, taşqi xotira qurilmalari va boşqa periferiyalar uçun mos keladi, şuning uçun ortiqça ötkazgiçlar endi kerak bölmaydi.
                Aloqa, himoya va zamonaviy dizayn
                5G, LTE, Wi-Fi va Bluetooth 6.0 qöllab-quvvatlaşi barqaror aloqa va tezkor ma’lumot uzatişni ta’minlaydi. NFC moduli kontaktsiz tölovga yöl oçadi, eSIM esa tariflarni, şu jumladan jismoniy nano-SIM bilan işlaşni moslaşuvçan boşqariş imkonini beradi. Alyuminiy va qora rangli şişadan yasalgan korpusning oğirligi 211 gramm bölib, u jiddiy va olijanob körinişga ega, IP68 himoya darajasi esa smartfonni kundalik hayotda suv va çangdan himoya qiladi.',
        ]);

        ProductVariant::create([
            'product_id' => $iphone18Pro256->id,
            'name' => '12/256 Black',
            'sku' => 'APL-IP18-12-256-BLK',
            'price' => 19000000,
            'stock' => 50,
        ]);

        $iphone18Pro256->attributeValue()->attach([
            $ram12->id,
            $storage512->id,
            $colorBlack->id,
        ]);


        $iphone18Pro512 = Product::create([
            'category_id' => $smartphonesCat->id,
            'brand_id' => $appleBrand->id,
            'name' => 'Apple iPhone 18 Pro 12/512 GB',
            'slug' => 'apple-iphone-18-pro-12-512gb',
            'price' => 25000000,
            'description' => 'Dizayn va ishonchlilik. Apple iPhone 18 Pro 12/512GB Black — nafis tashqi ko‘rinish, zamonaviy texnologiyalar va keng funksional imkoniyatlarni o‘zida mujassamlashtirgan premium smartfon. To‘yingan qora rang modelga salobat bag‘ishlab, brendga xos ixcham bezaklarning jozibadorligini ta’kidlaydi. Alyuminiy qismlar hamda shisha yuzalarning uyg‘unligi mustahkam tuzilmani shakllantirib, kundalik foydalanishda yoqimli taktil hissiyotlarni ta’minlaydi. Klassik shakl muvozanatli o‘lchamlari bilan ajralib turadi, shu sababli suhbatlashish, internet sahifalarini ko‘rish yoki videomateriallarni tomosha qilish paytida qurilma kaftda qulay joylashadi. 211 gramm og‘irlik konstruksiyaning puxtaligini aks ettirib, ishlatish davomida komfortni saqlaydi. IP68 himoya standarti belgilangan sinov sharoitlarida ichki komponentlarni chang va suv kirishidan muhofaza qilishni nazarda tutadi. Bunday ijro uzoq xizmat qiladigan mobil texnikani afzal ko‘ruvchi faol insonlar uchun muhim ustunlik hisoblanadi.
                Displey va vizual taassurotlar. Zamonaviy 6,3 dyuymli Super Retina XDR ekrani yorqin rang uzatish, ajoyib kontrast va grafik kontentni batafsil aks ettirish imkonini beradi. 2622×1206 pikselli aniqlik tasvirdagi eng kichik elementlarni ham farqlashga yordam beradi, 460 PPI ko‘rsatkichi esa namoyish etilayotgan ma’lumotlarning nihoyatda tiniq bo‘lishiga xizmat qiladi. 19,5:9 formatidagi panel kitob o‘qish, filmlar tomosha qilish, suratlarni tahrirlash hamda veb-resurslardan foydalanish uchun qulay sharoit yaratadi. 120 Gts yangilanish chastotasi interfeys bo‘ylab harakatlanishni ravonlashtirib, animatsiyalarga tabiiylik, dinamik o‘yin sahnalariga esa qo‘shimcha ta’sirchanlik bag‘ishlaydi. Maxsus Ceramic Shield 2 qoplamasi old yuzaning odatiy ishlatish jarayonida yuzaga keladigan mexanik shikastlanishlarga chidamliligini oshiradi. Ushbu xususiyatlar majmuasi ko‘ngilochar mashg‘ulotlar, ijodkorlik va kasbiy faoliyat uchun mukammal vizual muhitni shakllantiradi.
                Kamera va suratga olish imkoniyatlari. Takomillashtirilgan fotografiya majmuasi har biri 48 MP aniqlikka ega uchta asosiy kameradan tashkil topgan bo‘lib, sifatli vizual materiallar yaratish uchun keng imkoniyatlar ochadi. Yuqori darajadagi detallash teksturalarning nozik jihatlarini, ifodali rang o‘tishlarini va atrofdagi obyektlarning mayda xususiyatlarini aniq yetkazishga yordam beradi. Ko‘p modulli konfiguratsiya portret kompozitsiyalari, tabiat manzaralari, shahar me’morchiligi hamda unutilmas voqealarni tasvirga olish kabi turli fotografik vaziyatlarga moslashtirilgan. Zamonaviy kadrlarni qayta ishlash texnologiyalari ranglarning to‘g‘ri aks etishiga va fotosuratlarning tabiiy ko‘rinishini saqlashga ko‘maklashadi. 18 MP old kamera jozibali selfilar, masofaviy muloqot, onlayn uchrashuvlar va raqamli platformalar uchun videomateriallar tayyorlashga mos keladi. Ijodiy funksiyalarning xilma-xilligi mazkur telefonni sayohatchilar, blogerlar hamda mobil fotografiya ixlosmandlari uchun jozibador vositaga aylantiradi.
                Unumdorlik va ma’lumotlarni saqlash. Hisoblash jarayonlari uchun ilg‘or 2 nanometrli texnologik jarayon asosida ishlab chiqarilgan olti yadroli A20 Pro protsessori javob beradi. Yuqori samaradorlikka ega platforma murakkab operatsiyalarni tezkor bajarish, tizim resurslarini oqilona boshqarish va energiya sarfini optimallashtirishga mo‘ljallangan. 12 GB tezkor xotira bir vaqtning o‘zida bir nechta vazifani bajarish, dasturlar o‘rtasida tez almashish hamda talabchan ilovalarning barqaror ishlashini ta’minlaydi. 512 GB ichki xotira keng fotoarxivlar, videoroliklar to‘plamlari, hujjatlar, musiqiy kutubxonalar va zamonaviy o‘yinlarni joylashtirish imkonini beradi. Konstruksiyada qo‘shimcha microSD karta uyasi mavjud emas. iOS 27 operatsion tizimi tushunarli navigatsiya, moslashuvchan sozlamalar, foydali raqamli vositalar va Apple ekotizimidagi mos mahsulotlar bilan uyg‘un ishlash imkoniyatlarini taklif etadi. Bunday apparat konfiguratsiyasi intensiv foydalanishda yuqori tezlik, amaliylik va barqarorlikni qadrlaydigan insonlarga mos keladi.
                Avtonom ishlash, aloqa va qo‘shimcha funksiyalar. Quvvat manbai sifatida 4056 mA·soat sig‘imli litiy-ion akkumulyator xizmat qilib, mobil qurilmaning asosiy komponentlarini energiya bilan ta’minlaydi. Hisoblash jarayonlarining oqilona tashkil etilishi mavjud zaryaddan tejamkor foydalanishga yordam beradi. Tezkor quvvatlash funksiyasi batareya zaxirasini qisqa muddatda tiklashga ko‘maklashib, elektr manbaiga ulanish davomiyligini kamaytiradi. Universal USB Type-C porti mos simli aksessuarlar, audioqurilmalar va zaryadlash kabellarini ulash uchun ishlatiladi. 5G va LTE standartlari zamonaviy uyali tarmoqlarga bog‘lanish, axborot almashish, striming kontentini tomosha qilish hamda internet xizmatlaridan foydalanish imkoniyatini yaratadi. Bluetooth 6.0 texnologiyasi garnituralar, akustik tizimlar va boshqa elektron jihozlar bilan simsiz bog‘lanishni ta’minlaydi. Wi-Fi tarmoqqa ulanish imkoniyatlarini kengaytiradi, NFC esa mos kontaktsiz xizmatlardan foydalanishga mo‘ljallangan. nano-SIM va eSIM qo‘llab-quvvatlanishi mobil operatorlarga ulanishning qo‘shimcha variantlarini taqdim etadi. Qora rangdagi Apple iPhone 18 Pro xizmat safarlari, kundalik yumushlar, sayohatlar va ijodiy loyihalarda munosib hamroh bo‘ladi.',
        ]);

        ProductVariant::create([
            'product_id' => $iphone18Pro512->id,
            'name' => '12/512 Black',
            'sku' => 'APL-IP18-12-512-BLK',
            'price' => 25000000,
            'stock' => 50,
        ]);

        $iphone18Pro512->attributeValue()->attach([
            $ram12->id,
            $storage512->id,
            $colorBlack->id,
        ]);


        // Creating laptop product
        $asus = Product::create([
            'category_id' => $laptopsCat->id,
            'brand_id' => $asusBrand->id,
            'name' => 'Asus VivoBook 15',
            'slug' => 'asus-vivobook-15',
            'price' => 8999000,
            'description' => "Asus VivoBook 15 ASUS Vivobook 15 - bu barcha turdagi vazifalar va o'yin-kulgilar uchun mos keladigan eng yangi gadjet. 
                Unda chastotasi 1,3 dan 4,4 gigagertsgacha bo'lgan Intel Core i5-1235U chipi va Intel Iris Xe grafik kartasi mavjud bo'lib, 
                u ko'p vazifali rejimda ham haddan tashqari quvvat va tezkor ishlashni ta'minlaydi.
                1920x1080 o‘lchamli 15,6 dyuymli diagonali displey va IPS matritsasi keng ko‘rish 
                burchaklariga ega yorqin va aniq tasvirni taqdim etadi, bu esa qulay ishlash imkonini 
                beradi. Ekranni yangilash tezligi 60 Gts ni tashkil qiladi, bu video va o'yinlarning 
                muammosiz ijro etilishini ta'minlaydi.
                M.2 NVMe PCIe 3.0 SSD-da 8 Gb tezkor xotira va 512 Gb ROM bilan ushbu qurilma barcha 
                fayllar va ilovalaringiz uchun juda ko'p saqlash joyini ta'minlaydi. Dinamiklarning 
                mavjudligi yuqori sifatli ovozdan bahramand bo'lish imkonini beradi va 720p HD veb-kamera 
                ushbu qurilmani videokonferentsiya va onlayn muloqot uchun ideal qiladi.
                Wi-Fi5 va Bluetooth 5.1-ni qo'llab-quvvatlash tezkor va uzluksiz internetni taqdim etadi. 
                42 Vt akkumulyator sig‘imi uzoq vaqt davomida qayta zaryadlanmasdan ishlash imkonini beradi, 
                zaryadlovchi esa paketga kiritilgan bo‘lib, qulaylik va harakatchanlik beradi."
        ]);

        ProductVariant::Create([
            'product_id' => $asus->id,
            'name' => '16/512 Silver',
            'sku' => 'ASUS-VB15-16-512-SLV',
            'price' => 8999000,
            'stock' => 10,
        ]);

        $asus->attributeValue()->attach([
            $ram16->id,
            $storage512->id,
            $colorSilver->id
        ]);


        $hpPavilion = Product::create([
            'category_id' => $laptopsCat->id,
            'brand_id' => $hpBrand->id,
            'name' => 'HP Pavilion 15',
            'slug' => 'hp-pavilion-15',
            'price' => 7499000,
            'description' => 'Pavilion HP 15 noutbugi yuqori mahsuldorligi va ixchamligi bilan farq 
                qiladi, bu harakatlanishning to’liq erkinligini saqlagan holda, yanada samarali ishlash imkonini beradi.
                Bir qadam oldinda bo’lish imkonini beruvchi mahsuldorlik. Premium sinf AMD protsessori tufayli 
                har qanday vazifalarni bajarishga yordam beruvchi noutbuk.
                DDR4 xotira — bu TX (OZU) ning kelajagi. U yuqori mahsuldorligi, ishonchliligi va 
                ishlash tezligi bilan farq qiladi.
                Ingichka hoshiyalari tufayli ko’rish sohasining kattalashtirilishi ekranda ko’proq 
                ma’lumot aks ettirish imkonini beradi.',
        ]);

        ProductVariant::create([
            'product_id' => $hpPavilion->id,
            'name' => '16/512 Silver',
            'sku' => 'HP-PAV15-16-512-SLV',
            'price' => 7499000,
            'stock' => 15,
        ]);

        $hpPavilion->attributeValue()->attach([
            $ram16->id,
            $storage512->id,
            $colorSilver->id,
        ]);


        // TVs. SAMSUNG TV
        $samsungTV = Product::create([
            'category_id' => $tvsCat->id,
            'brand_id' => $SamsungBrand->id,
            'name' => "Samsung S95H 4K 55 dyum",
            'slug' => 'samsung-s95h-4k-55',
            'price' => 20000000,
            'description' => "Samsung S95H 55 dyuymli 4K televizori — o'ta yupqa Infinity One dizayniga ega, zamonaviy QD-OLED panelli flagman model. 
                3840 × 2160 (4K Ultra HD) o'lchamli ekran UL Solutions tomonidan tasdiqlangan Glare Free mat qoplamasi va VDE sertifikatiga ega 
                'Real Black' chuqur qora rang texnologiyasi bilan jihozlangan bo'lib, yorug' xonalarda ham shu'lasiz va tiniq tasvirni ta'minlaydi.
                Tasvirni qayta ishlash uchun NQ4 AI Gen3 sun'iy intellekt protsessori javob beradi — u 4K AI Upscaling Pro, Auto HDR 
                Remastering Pro, Real Depth Enhancer hamda Vision AI Companion funksiyalarini qo'llab-quvvatlaydi. OLED HDR Pro texnologiyasi 
                HDR10, HDR10+ va HLG formatlari bilan birgalikda yuqori yorqinlik va boy kontrastni taqdim etadi. Geymerlar uchun 165 Hz 
                yangilanish tezligi (Motion Xcelerator 165Hz), 4 ta HDMI 2.1 porti, AMD FreeSync Premium Pro va NVIDIA G-SYNC texnologiyalari ko'zda tutilgan.
                Ovoz tizimi 70 Vt quvvatga ega 4.2.2 kanalli dinamiklardan iborat bo'lib, Dolby Atmos, Object Tracking Sound+ (OTS+), 
                AI Sound Pro va Q-Symphony texnologiyalari orqali hajmli va tiniq audioni yaratadi. Televizor Tizen OS operatsion tizimida ishlaydi, 
                minglab san'at asarlarini namoyish etuvchi Art Mode / Art Store rejimiga ega va quyosh nuridan quvvatlanuvchi 
                SolarCell Remote pulti bilan birga keladi" 
        ]);

        ProductVariant::create([
            'product_id' => $samsungTV->id,
            'name' => '55 inch Black',
            'sku' => 'SAM-TV-S95H-4K-55-BLK',
            'price' => 20000000,
            'stock' => 50
        ]);

        $samsungTV->attributeValue()->attach([
            $screen55->id,
            $res4k->id
        ]);


        // ARTEL TV
        $screen32 = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'screen-size'))->where('value', '32')->first();
        $resFHD = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'resolution'))->where('value', 'Full HD')->first();

        $artelTV = Product::create([
            'category_id' => $tvsCat->id,
            'brand_id' => $artelBrand->id,
            'name' => 'Artel UA43H3502 Smart Televizori',
            'slug' => 'artel-ua43h6502-smart-tv',
            'price' => 3850000,
            'description' => "Televizor Artel UA43H3502 Smart — funksional imkoniyatlar, zamonaviy dizayn va 
                yuqori tasvir sifati bilan ajralib turadigan ko‘p qirrali multimedia qurilmasidir. Model 43 
                dyuymli (109 sm) UHD 4K displey (3840×2160 piksel) bilan jihozlangan bo‘lib, u aniq va batafsil 
                tasvirni ta’minlaydi. IPS matritsa tufayli ranglar tabiiy ko‘rinadi va har qanday burchakda 
                yorqinlik yo‘qolmaydi. 60 Gts yangilanish tezligi tasvirlarni silliq va yoqimli qiladi. 16:9 
                formatdagi ekran filmlar va videolarni tomosha qilish uchun qulay, shovqinni kamaytirish 
                texnologiyasi esa tasvirni yanada tiniqlashtiradi.
                Qurilma Android platformasi asosida ishlaydi, bu esa uni to‘liq funksiyali ko‘ngilochar markazga 
                aylantiradi. YouTube, Netflix, Megogo kabi mashhur servislar va boshqa ilovalardan foydalanish mumkin. 
                Smart TV funksiyasi orqali tashqi qurilmalarsiz to‘g‘ridan-to‘g‘ri kontentni ishga tushirish imkoniyati 
                mavjud. Qurilma kengaytirilgan interfeyslar bilan ta’minlangan: 2 ta HDMI port (2.0 versiya), 2 ta USB 2.0, 
                LAN (RJ-45) kirish va 3.5 mm naushnik uchun chiqish. Bularning barchasi televizorni har tomonlama qulay qiladi.
                Modelda analog (PAL/SECAM) va raqamli televideniya (DVB-T/T2, DVB-C, DVB-S/S2) standartlarini 
                qo‘llab-quvvatlaydigan ichki tyunerlar mavjud. Qurilma H.264, MPEG4, MP3 formatlarini va USB orqali 
                fayllarni ijro etishni qo‘llab-quvvatlaydi. Bu esa kino, musiqalar yoki rasmlarni fleshka yoki tashqi 
                diskdan to‘g‘ridan-to‘g‘ri tomosha qilish imkonini beradi. Bu xususiyat oflayn kontentni yoqtiradigan 
                foydalanuvchilar uchun juda foydalidir. 2×10 Vt quvvatga ega ovoz tizimi Dolby Digital texnologiyasi 
                orqali boy va tiniq tovushni ta’minlaydi. Qurilmani stol ustiga qo‘yish yoki devorga VESA kronshteyni 
                yordamida osib o‘rnatish mumkin. Televizor O‘zbekistonda ishlab chiqarilgan, bu esa texnologik imkoniyatlar, 
                ishonchlilik va maqbul narxning muvozanatini kafolatlaydi. Artel UA43H3502 Smart — oilaviy foydalanish uchun 
                qulay, tasvir sifati yuqori va zamonaviy funksiyalarga ega televizor izlayotganlar uchun ideal tanlovdir."
        ]);

        ProductVariant::create([
            'product_id' => $artelTV->id,
            'name' => '32 inch Black',
            'sku' => 'ART-UA43H3502',
            'price' => 3850000,
            'stock' => 20
        ]);

        $artelTV->attributeValue()->attach([
            $screen32->id,
            $resFHD->id
        ]);


        // LG TV
        $screen65 = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'screen-size'))->where('value', '65')->first();
        $res8K = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'resolution'))->where('value', '8K')->first();

        $lgTV = Product::create([
            'category_id' => $tvsCat->id,
            'brand_id' => $LgBrand->id,
            'name' => 'LG NANO96 65 dyumli 8K Televizor',
            'slug' => 'lg-tv-nano96-65-inch-8k',
            'price' => 28000000,
            'description' => "LG NANO96 65 dyuymli 8K NanoCell televizori — o'ta yuqori 7680 × 4320 (8K Ultra HD) 
                o'lchamli IPS matritsa va to'liq matritsali yoritish (Full Array Dimming) tizimiga ega zamonaviy model. 
                Nano Color texnologiyasi hamda 10 bitli rang palitrasi milliardlab tabiiy va tiniq ranglarni aks ettiradi.
                Tasvirni qayta ishlash uchun 4-avlod α9 8K intellektual protsessori javob beradi — u AI 8K Upscaling, 
                AI Picture Pro 8K, Ultra Luminance Pro hamda Cinema HDR (Dolby Vision IQ, HDR10 Pro, HLG) texnologiyalarini 
                qo'llab-quvvatlaydi. FILMMAKER™ rejimi filmlarni rejissyor o'ylagan asl ko'rinishda tomosha qilish imkonini 
                beradi, o'yinlar uchun esa ALLM va HGiG rejimlari ko'zda tutilgan.
                40 Vt quvvatga ega 2.2 kanalli audio tizim (ikkita 10 Vt sabvufer bilan) Dolby Atmos®, AI Sound Pro, 
                Ultra Surround va Clear Voice Pro texnologiyalari orqali chuqur va hajmli ovozni ta'minlaydi. Televizor 
                webOS 6.0 Smart TV platformasida ishlaydi, LG ThinQ AI, Apple AirPlay 2 va Apple HomeKit tizimlarini 
                qo'llab-quvvatlaydi hamda qulay Magic Remote pulti bilan jihozlangan."
        ]);

        ProductVariant::create([
            'product_id' => $lgTV->id,
            'name' => '65 inch Black',
            'sku' => 'LG-TV-NANO96-65-8K-BLK',
            'price' => 28000000,
            'stock' => 20
        ]);

        $lgTV->attributeValue()->attach([
            $screen65->id,
            $res8K->id
        ]);


        //  FRIDGES.Bosch Fridge
        $boschCap = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'capacity'))->where('value', '574 L')->first();
        $boschColor = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'color'))->where('value', 'Stainless Steel')->first();
        
        $boschFridge = Product::create([
            'category_id' => $fridgesCat->id,
            'brand_id' => $boschBrand->id,
            'name' => 'Bosch Serie 6 French Door Fridge',
            'slug' => 'bosch-serie-6-french-door-fridge',
            'price' => 18500000,
            'description' => "Bosch Serie 6 KFD96APEA – French Door uslubidagi, to‘rt eshikli, 
                katta hajmli sovutgich. Umumiy hajmi 574 litr: sovutish kamerasi 375 litr, muzlatgich 
                kamerasi 199 litr. Katta oilalar va ko‘p mahsulot saqlaydiganlar uchun ideal tanlov.\n\nNoFrost 
                texnologiyasi tufayli sovutgichni hech qachon qo‘lda eritish kerak bo‘lmaydi: kamerada 
                muz qatlami hosil bo‘lmaydi. VitaFresh XXL tortmalari 0°C ga yaqin haroratda go‘sht, 
                baliq, meva va sabzavotlarni uzoq vaqt yangi va vitaminlarga boy holda saqlaydi.\n\nZanglamas 
                po‘latdan yasalgan eshiklar barmoq izi qolmaydigan qoplamaga ega, shuning uchun 
                sovutgich doim toza va zamonaviy ko‘rinadi. Eshik ochiq qolsa yoki harorat ko‘tarilsa, 
                qurilma ovozli va yorug‘lik signali beradi.\n\nTexnik xususiyatlari:\n• Umumiy hajm: 
                574 L\n• Sovutish kamerasi: 375 L\n• Muzlatgich kamerasi: 199 L\n• Muzlatish quvvati: 
                sutkasiga 16 kg gacha\n• Muzlatgich tortmalari: 6 ta shaffof tortma\n• Shovqin darajasi: 
                39 dB\n• Energiya samaradorligi sinfi: E\n• O‘lchamlari (B×E×Ch): 1830 × 905 × 731 mm\n• 
                Og‘irligi: 138 kg\n• Rangi: zanglamas po‘lat."
        ]);

        ProductVariant::create([
            'product_id' => $boschFridge->id,
            'name' => '505L Stainless Steel',
            'sku' => 'BOSCH-FRIDGE-574L-SS',
            'price' => 18500000,
            'stock' => 12
        ]);
        
        $boschFridge->attributeValue()->attach([
            $boschCap->id,
            $boschColor->id
        ]);


        // Samsung RT32FAJBDSA (322L) Fridge
        $samsungCap = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'capacity'))->where('value', '322 L')->first();
        $samsungColor = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'color'))->where('value', 'Stainless Steel')->first();

        $samsungFridge = Product::create([
            'category_id' => $fridgesCat->id,
            'brand_id' => $SamsungBrand->id,
            'name' => 'Samsung RT32FAJBDSA 322L Sovutgichi',
            'slug' => 'samsung-rt32fajbdsa-322l-sovutgichi',
            'price' => 7800000,
            'description' => "Samsung RT32FAJBDSA – yuqori muzlatgichli, kumush rangli ikki kamerali 
                sovutgich. Umumiy foydali hajmi 322 litr: sovutish kamerasi 250 litr, muzlatgich kamerasi 
                72 litr. Kichik va o‘rta oilalar uchun qulay tanlov.\n\nQurilmada Samsung Digital Inverter 
                kompressori o‘rnatilgan: u ishlash rejimini yuklamaga qarab moslashtiradi, shu sababli kam 
                elektr energiyasi sarflaydi, jim ishlaydi va uzoq xizmat qiladi. Kompressorga 10 yillik 
                kafolat beriladi.\n\nMoistFresh zonasi meva va sabzavotlar uchun maqbul namlikni saqlaydi, 
                shuning uchun mahsulotlar uzoq vaqt yangiligicha qoladi.\n\nTexnik xususiyatlari:\n• 
                Foydali hajm: 322 L (umumiy hajm 333 L)\n• Sovutish kamerasi: 250 L\n• Muzlatgich kamerasi: 
                72 L\n• O‘lchamlari (E×B×Ch): 600 × 1710 × 719 mm\n• Og‘irligi: 58 kg\n• Kompressor: 
                Digital Inverter\n• Rangi: kumush."
        ]);

        ProductVariant::create([
            'product_id' => $samsungFridge->id,
            'name' => '322L Stainless Steel',
            'sku' => 'SAMSUNG-FRIDGE-322L',
            'price' => 7800000,
            'stock' => 20
        ]);
        
        $samsungFridge->attributeValue()->attach([
            $samsungCap->id,
            $samsungColor->id
        ]);


        // Sovutgich ARTEL HD 430 RWENE
        $artelCap = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'capacity'))->where('value', '330 L')->first();
        $artelColor = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'color'))->where('value', 'Stainless Steel')->first();

        $artelFridge = Product::create([
            'category_id' => $fridgesCat->id,
            'brand_id' => $artelBrand->id,
            'name' => 'Sovutgich ARTEL HD 430 RWENE',
            'slug' => 'sovutgich-artel-hd-430-rwene',
            'price' => 7600000,
            'description' => 'ARTEL HD 430 RWENE sovutgichi - bu invertorli motorli ikki kamerali sovutgich 
            yuqori energiya samaradorligi (sinfi A+, iste’moli 286 kVt/soat/yil) va atigi 42 dB shovqin 
            darajasida shovqinsiz ishlashni o‘zida mujassam etgan.'
        ]);

        ProductVariant::create([
            'product_id' => $artelFridge->id,
            'name' => '322L Stainless Steel',
            'sku' => 'FRIDGE-ARTEL-HD-430-RWENE',
            'price' => 7600000,
            'stock' => 20
        ]);
        
        $artelFridge->attributeValue()->attach([
            $artelCap->id,
            $artelColor->id
        ]);


        // WASHING MACHINES. LG F2V3PS6W
        $lgCap = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'capacity'))->where('value', '8 kg')->first();
        $lgColor = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'color'))->where('value', 'White')->first();

        $lgWashingMachine = Product::create([
            'category_id' => $washingMachineCat->id,
            'brand_id' => $LgBrand->id,
            'name' => 'Kir yuvish mashinasi LG F2V3PS6W',
            'slug' => 'kir-yuvish-mashinasi-lg-f2v3ps6w',
            'price' => 6000000,
            'description' => "LG F2V3PS6W kir yuvish mashinasi - bu yuqori yuvish samaradorligi, 
            foydalanish qulayligi va zamonaviy dizaynni o'zida mujassam etgan uyingiz uchun zamonaviy yechimdir."
        ]);

        ProductVariant::create([
            'product_id' => $lgWashingMachine->id,
            'name' => 'Washing Machine LG F2V3PS6W White',
            'sku' => 'WASHING-MACHINE-LG-F2V3PS6W',
            'price' => 6000000,
            'stock' => 20
        ]);

        $lgWashingMachine->attributeValue()->attach([
            $lgCap->id,
            $lgColor->id
        ]);


        // Samsung WW70AG4S21VELD kir yuvish mashinasi
        $samsungCap = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'capacity'))->where('value', '7 kg')->first();
        $samsungColor = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'color'))->where('value', 'White')->first();

        $samsungWashingMachine = Product::create([
            'category_id' => $washingMachineCat->id,
            'brand_id' => $SamsungBrand->id,
            'name' => 'Kir yuvish mashinasi Samsung WW70AG4S21VELD',
            'slug' => 'kir-yuvish-mashinasi-samsung-ww70ag4s21veld',
            'price' => 5000000,
            'description' => "Samsung WW70AG4S21VELD kir yuvish mashinasi 7 kg gacha bo‘lgan frontal yuklash 
                va maksimal yuklash imkoniyati bilan kichik oilalar va joy hamda energiyani tejashni istaydigan 
                odamlar uchun ajoyib yechimdir."
        ]);

        ProductVariant::create([
            'product_id' => $samsungWashingMachine->id,
            'name' => 'Washing Machine Samsung WW70AG4S21VELD White',
            'sku' => 'WASHING-MACHINE-SAMSUNG-WW70AG4S21VELD',
            'price' => 5000000,
            'stock' => 20
        ]);

        $samsungWashingMachine->attributeValue()->attach([
            $samsungCap->id,
            $samsungColor->id
        ]);


        // Toshiba TW-BL80A2UZ(WK) kir yuvish mashinasi
        $toshibaCap = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'capacity'))->where('value', '7 kg')->first();
        $toshibaColor = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'color'))->where('value', 'White')->first();

        $toshibaWashingMachine = Product::create([
            'category_id' => $washingMachineCat->id,
            'brand_id' => $toshibaBrand->id,
            'name' => 'Kir yuvish mashinasi Toshiba TW-BL80A2UZ(WK)',
            'slug' => 'kir-yuvish-mashinasi-toshiba-tw-bl80a2uz-wk',
            'price' => 4500000,
            'description' => "Toshiba TW-BL80A2UZ(WK) kir yuvish mashinasi 7 kg gacha bo‘lgan frontal yuklash 
                va maksimal yuklash imkoniyati bilan kichik oilalar va joy hamda energiyani tejashni istaydigan 
                odamlar uchun ajoyib yechimdir."
        ]);

        ProductVariant::create([
            'product_id' => $toshibaWashingMachine->id,
            'name' => 'Washing Machine Toshiba TW-BL80A2UZ(WK) White',
            'sku' => 'WASHING-MACHINE-TOSHIBA-TW-BL80A2UZ(WK)',
            'price' => 4500000,
            'stock' => 20
        ]);

        $toshibaWashingMachine->attributeValue()->attach([
            $toshibaCap->id,
            $toshibaColor->id,
        ]);


        // Hisense Washing Machine
        $hisenseCap = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'capacity'))->where('value', '7 kg')->first();
        $hisenseColor = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'color'))->where('value', 'White')->first();

        $hisenseWashingMachine = Product::create([
            'category_id' => $washingMachineCat->id,
            'brand_id' => $hisenseBrand->id,
            'name' => 'Kir yuvish mashinasi Hisense WFQP7012EVM',
            'slug' => 'kir-yuvish-mashinasi-hisense-wfqp7012evm',
            'price' => 4950000,
            'description' => 'Sig‘im va rejimlar
                Hisense WFQP7012EVM kundalik kiyimlar, choyshablar va uy tekstilini muntazam parvarish qilish uchun mos keladi. 7 kg gacha yuklama bir siklda yetarlicha ko‘p buyumni yuvish imkonini beradi, bu bir necha kishilik oila uchun qulay. Old tomonda joylashgan lyuk barabanga odatiy tarzda kirishni ta’minlaydi, o‘rtacha suv sarfi esa 43 litrni tashkil etadi. Foydalanuvchi ixtiyorida 15 ta dastur mavjud bo‘lib, ular orasida patli buyumlar uchun alohida rejim ham bor. Yuvish samaradorligi A sinfiga mos keladi. Quritish funksiyasi mavjud emas, shu sababli jarayon tugagach kiyimlarni tabiiy usulda yoki alohida quritgich yordamida quritish kerak bo‘ladi.
                Motor va siqish
                Model Inverter PowerDrive invertor dvigateli bilan jihozlangan bo‘lib, mexanizmning silliq ishlashi va barabanning barqaror aylanishini ta’minlaydi. Siqish tezligi 1200 ayl/min gacha yetadi, bu matodagi namlikning katta qismini olib tashlashga yordam beradi. Ushbu bosqich samaradorligi B sinfiga kiradi. Maksimal shovqin darajasi 74 dB deb ko‘rsatilgan, shu sababli o‘rnatish joyini oldindan to‘g‘ri tanlash maqsadga muvofiq. Elektron boshqaruv paneli kerakli ssenariyni tez tanlash va parametrlarni murakkab sozlamalarsiz belgilash imkonini beradi.
                Tejamkorlik va himoya
                Energiya iste’moli A sinfiga mos bo‘lib, Hisense WFQP7012EVM’ni tez-tez foydalanish uchun amaliy variantga aylantiradi. Suv sizib chiqishidan himoya tizimi ta’minot bilan bog‘liq noxush holatlar xavfini kamaytiradi, bolalardan bloklash funksiyasi esa ish jarayonida sozlamalarning tasodifan o‘zgarishini oldini oladi. Ishga tushirilgandan keyin qo‘shimcha kiyim solish imkoniyati mavjud emas, shu sababli barcha buyumlarni oldindan joylashtirish tavsiya etiladi. Plastik bak namlikka chidamli va konstruksiyaning umumiy vaznini kamaytirishga yordam beradi.
                O‘lcham va tashqi ko‘rinish
                Korpus universal oq rangda ishlangan bo‘lib, vannaxona, oshxona yoki alohida kir yuvish hududi interyeriga oson mos tushadi. O‘lchamlari 59,5 × 84,5 × 45 sm, shu bois texnika nisbatan ixcham chuqurlikka ega va joy cheklangan xonalarga ham mos kelishi mumkin. Vazni 59 kg, bu to‘g‘ri o‘rnatilgandan so‘ng barqaror turishga yordam beradi. 7 kg yuklama, 15 ta rejim, 1200 ayl/min, invertor motor va himoya funksiyalari uyg‘unligi ushbu kir yuvish mashinasini kundalik parvarish uchun qulay yechimga aylantiradi.',
        ]);

        ProductVariant::create([
            'product_id' => $hisenseWashingMachine->id,
            'name' => 'Washing Machine Hisense WFQP7012EVM',
            'sku' => 'HIS-WFQP7012EVM-7KG-WHT',
            'price' => 4500000,
            'stock' => 20
        ]);

        $hisenseWashingMachine->attributeValue()->attach([
            $hisenseCap->id,
            $hisenseColor->id,
        ]);

        // AIR CONDITIONER LG B18TS
        $lgAcCap = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'ac-capacity'))->where('value', '18000 BTU')->first();
        $lgColor = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'color'))->where('value', 'White')->first();

        $lgAC = Product::create([
            'category_id' => $acCat->id,
            'brand_id' => $LgBrand->id,
            'name' => 'LG B18TS Konditsioneri',
            'slug' => 'lg-b18ts-konditsioneri',
            'price' => 12000000,
            'description' => "LG B18TS konditsioneri 18 000 Vt quvvatga ega, u 40-50 kvadrat metrlik xona 
                uchun qulay harorat darajasini ta'minlay oladi. Inverterli kompressor yordamida konditsioner 
                pulni tejaydi va shovqinsiz ishlaydi."
        ]);

        ProductVariant::create([
            'product_id' => $lgAC->id,
            'name' => 'Air Conditioner LG B18TS White',
            'sku' => 'LG-AC-B18TS-WT',
            'price' => 12000000,
            'stock' => 20
        ]);

        $lgAC->attributeValue()->attach([
            $lgAcCap->id,
            $lgColor->id
        ]);


        // Konditsioner Samsung AR09TXHQASINUA
        $samsungAcCap = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'ac-capacity'))->where('value', '9000 BTU')->first();
        $samsungColor = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'color'))->where('value', 'White')->first();

        $samsungAC = Product::create([
            'category_id' => $acCat->id,
            'brand_id' => $SamsungBrand->id,
            'name' => 'Samsung AR09TXHQASINUA Konditsioneri',
            'slug' => 'samsung-ar09txhqasinua-konditsioneri',
            'price' => 3070000,
            'description' => "Samsung AR09TXHQASINUA – 25 kvadrat metrgacha bo'lgan 
                xonalarda qulay iqlim yaratish uchun ideal echimdir."
        ]);

        ProductVariant::create([
            'product_id' => $samsungAC->id,
            'name' => 'Air Conditioner Samsung AR09TXHQASINUA White',
            'sku' => 'SMSNG-AC-AR09TXHQASINUA-WT',
            'price' => 3070000,
            'stock' => 20
        ]);

        $samsungAC->attributeValue()->attach([
            $samsungAcCap->id,
            $samsungColor->id
        ]);


        // Artel 12HS S SIR1W12BE Konditsioneri
        $artelAcCap = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'ac-capacity'))->where('value', '12000 BTU')->first();
        $artelColor = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'color'))->where('value', 'White')->first();
        
        $artelAC = Product::create([
            'category_id' => $acCat->id,
            'brand_id' => $artelBrand->id,
            'name' => 'Artel 12HS S SIR1W12BE Konditsioneri',
            'slug' => 'artel-12hs-s-sir1w12be-konditsioneri',
            'price' => 5500000,
            'description' => "Artel 12HS S SIR1W12BE konditsioneri Artel brendi tomonidan ishlab chiqarilgan 
                devorga o'rnatilgan split tizimdir. U displeyga ega, bu uning parametrlarini boshqarish va sozlashni 
                osonlashtiradi. Ushbu konditsioner 12 000 BTU/soat quvvatga ega va barcha fasllarda qulay ichki 
                iqlimni saqlash uchun sovutish va isitish funksiyalarini taklif etadi. Xonada havoni aylantiradigan 
                shamollatish rejimi ham mavjud."
        ]);

        ProductVariant::create([
            'product_id' => $artelAC->id,
            'name' => 'Air Conditioner Artel 12HS S SIR1W12BE White',
            'sku' => 'ARTEL-AC-12HSSSIR1W12BE-WT',
            'price' => 5500000,
            'stock' => 20
        ]);

        $artelAC->attributeValue()->attach([
            $artelAcCap->id,
            $artelColor->id
        ]);


        // SMALL APPLIANCES. Steam Iron Braun FI3194BK
        $BraunIronPower = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'power'))->where('value', '2400 W')->first();
        $BraunColor = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'color'))->where('value', 'Blue')->first(); 
        
        $BraunIron = Product::create([
            'category_id' => $SmallAppliancesCat->id,
            'brand_id' => $BraunBrand->id,
            'name' => 'Dazmol Braun FI3194BK',
            'slug' => 'dazmol-braun-fi3194bk',
            'price' => 700000,
            'description' => "BraunFI3194BK dazmoli -  tez, samarali va boshqarish juda oson. 
                U FreeGlide3D texnologiyasi bilan jihozlangan bo‘lib, u har qanday to‘siqdan sirpanib 
                o‘tish imkonini beradi. Shuningdek, u ochiq FreeStyleBraun tutqichiga ega. Ushbu ergonomik 
                tutqich maksimal harakat erkinligini va qulay dazmollashni ta’minlaydi. SuperCeramic sizga 
                kamroq harakat bilan tezda ajoyib natijalarga erishish imkonini beradi."
        ]);

        ProductVariant::create([
            'product_id' => $BraunIron->id,
            'name' => 'Dazmol Braun FI3194BK Blue',
            'sku' => 'BRAUN-FI3194-IRON',
            'price' => 700000,
            'stock' => 20
        ]);

        $BraunIron->attributeValue()->attach([
            $BraunIronPower->id,
            $BraunColor->id
        ]);


        // Dazmol Philips DST8021/30
        $PhilipsIronPower = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'power'))->where('value', '3000 W')->first();
        $PhilipsColor = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'color'))->where('value', 'Purple')->first();
        
        $PhilipsIron = Product::create([
            'category_id' => $SmallAppliancesCat->id,
            'brand_id' => $PhilipsBrand->id,
            'name' => 'Dazmol Philips DST8021/30',
            'slug' => 'dazmol-philips-dst8021-30',
            'price' => 1300000,
            'description' => "3000 W quvvatga ega dazmol tezda ish haroratiga yetib, kiyimlarni 
                parvarish qilishni deyarli darhol boshlash imkonini beradi. 55 g/min gacha bo‘lgan 
                doimiy bug‘ oqimi tolalarni samarali yumshatib, sezilarli burmalar va qurib qolgan 
                joylarni tekislaydi. Kuchaytirilgan bug‘ zarbasi qalin materiallarda yaxshi natija 
                beradi, o‘rnatilgan purkagich esa murakkab qismlarni namlab, kamroq harakat bilan 
                saranjom ko‘rinishga erishishga yordam beradi."
        ]);

        ProductVariant::create([
            'product_id' => $PhilipsIron->id,
            'name' => 'Dazmol Philips DST8021/30 Purple',
            'sku' => 'PHILIPS-DST8021-IRON',
            'price' => 1300000,
            'stock' => 20
        ]);

        $PhilipsIron->attributeValue()->attach([
            $PhilipsIronPower->id,
            $PhilipsColor->id
        ]);


        // Vacuum Cleaner 
        $SamsungVacuumPower = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'power'))->where('value', '2000 W')->first();
        
        $SamsungVacuum = Product::create([
            'category_id' => $SmallAppliancesCat->id,
            'brand_id' => $SamsungBrand->id,
            'name' => 'Chang Yutgich Samsung VC20M255BWB/UZ',
            'slug' => 'chang-yutgich-samsung-vc20m255bwb-uz',
            'price' => 1300000,
            'description' => "Samsung VC20M255BWB/UZ changyutgichi uy, xonadon yoki ofisda samarali 
                quruq tozalash uchun mo‘ljallangan. 2000 Vt energiya sarfi qurilmaning barqaror ishlashini 
                ta’minlaydi, 460 Vt so‘rish quvvati esa gilam, pol va boshqa yuzalardagi chang, 
                mayda chiqindi, uvog‘ hamda turli iflosliklarni puxta yig‘ishga yordam beradi. 2,5 litr 
                sig‘imli qopcha uni tez-tez almashtirish zaruratini kamaytiradi, bu ayniqsa bir nechta 
                xonani tozalashda qulaydir. Qizil korpus texnikaga yorqin va zamonaviy ko‘rinish bag‘ishlaydi."
        ]);

        ProductVariant::create([
            'product_id' => $SamsungVacuum->id,
            'name' => 'Chang Yutgich Samsung VC20M255BWB/UZ',
            'sku' => 'SAMSUNG-VC20M255-VACUUM',
            'price' => 1300000,
            'stock' => 20
        ]);

        $SamsungVacuum->attributeValue()->attach([
            $SamsungVacuumPower->id,
            $colorRed->id,
        ]);


        // Chang Yutgich LG VC73189NHTS
        $LGVacuumPower = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'power'))->where('value', '2000 W')->first();
        $lgColor = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'color'))->where('value', 'Dark Blue')->first();
        
        $LgVacuum = Product::create([
            'category_id' => $SmallAppliancesCat->id,
            'brand_id' => $LgBrand->id,
            'name' => 'Chang Yutgich LG VC73189NHTS',
            'slug' => 'chang-yutgich-lg-vc73189nhts',
            'price' => 1700000,
            'description' => "LG VC73189NHTS 2000 W quvvatga ega, samarali va qulay tozalashni ta'minlovchi zamonaviy qurilma. 
                Kompressor changni siqish texnologiyasi konteynerga ko'proq chang yig'ish imkonini beradi, 
                bu esa yuqori quvvat va oson tozalashni ta'minlaydi. Uzunligi 5 m va diapazoni 8 m bo'lgan 
                quvvat simi doimiy ravishda qayta ulanishni talab qilmasdan xona bo'ylab erkin 
                harakatlanish imkonini beradi."
        ]);

        ProductVariant::create([
            'product_id' => $LgVacuum->id,
            'name' => 'Chang Yutgich LG VC73189NHTS',
            'sku' => 'LG-VC73189NHTS-VACUUM',
            'price' => 1700000,
            'stock' => 20
        ]);

        $LgVacuum->attributeValue()->attach([
            $LGVacuumPower->id,
            $lgColor->id
        ]);


        // MICROWAVE OVEN. LG MS2042DB
        $LgMicrowavePower = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'power'))->where('value', '700 W')->first();
        $LgMicrowaveCap = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'capacity'))->where('value', '20 L')->first(); 

        $LgMicrowave = Product::create([
            'category_id' => $SmallAppliancesCat->id,
            'brand_id' => $LgBrand->id,
            'name' => "Mikroto'lqinli Pech LG MS2042DB",
            'slug' => "mikrotolqinli-pech-lg-ms2042db",
            'price' => 1325000,
            'description' => "LG MS2042DB mikroto'lqinli pech oshxonadagi eng ishonchli yordamchidir. 
                Ovqat tayyorlash jarayonini tezlashtiring va osonlashtiring. Тugmali va sensorli kalitlar 
                qurilmani boshqarishni osonlashtiradi. Ular yordamida vaqt, vazn, quvvat va boshqa 
                funksiyalarini sozlashi mumkin. Siz taomlarni mazali pishirishingiz mumkin. Oddiy va 
                hayratlanarli dizayni mikroto'lqinli pechga chiroyli va zamonaviy ko‘rinish beradi. 
                To‘lqinli uch teng tarqatish tizimi pishirish kamerasini bir tekis isitadi, taomga har 
                tomondan kirib boradi. Buning yordamida taomlar bir xil pishadi. Bardoshli biotermik 
                qoplamani tozalash oson, tirnalmaydi va antibakterial. Ichki makonning yoritilishi 
                mikroto‘lqinli pechdan foydalanishni qulay qiladi. Pechning ish kamerasining foydali 
                hajmi ovqatni pishiradi, isitadi va muzdan tushiradi."
        ]);

        ProductVariant::create([
            'product_id' => $LgMicrowave->id,
            'name' => "Mikroto'lqinli Pech LG MS2042DB",
            'sku' => 'LG-MS2042DB-MICROWAVE',
            'price' => 1325000,
            'stock' => 20
        ]);

        $LgMicrowave->attributeValue()->attach([
            $LgMicrowavePower->id,
            $LgMicrowaveCap->id
        ]);


        // Mikroto`lqinli Pech Samsung ME83KRW-1KBW
        $SamsungMicrowavePower = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'power'))->where('value', '800 W')->first();
        $SamsungMicrowaveCap = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'capacity'))->where('value', '23 L')->first(); 

        $SamsungMicrowave = Product::create([
            'category_id' => $SmallAppliancesCat->id,
            'brand_id' => $SamsungBrand->id,
            'name' => "Mikroto'lqinli Pech Samsung ME83KRW-1KBW",
            'slug' => "mikrotolqinli-pech-samsung-me83krw-1kbw",
            'price' => 2300000,
            'description' => "Samsung ME83KRW-1KBW mikroto'lqinli pech oshxonadagi eng ishonchli yordamchidir. 
                Ovqat tayyorlash jarayonini tezlashtiring va osonlashtiring. Тugmali va sensorli kalitlar 
                qurilmani boshqarishni osonlashtiradi. Ular yordamida vaqt, vazn, quvvat va boshqa 
                funksiyalarini sozlashi mumkin. Siz taomlarni mazali pishirishingiz mumkin. Oddiy va 
                hayratlanarli dizayni mikroto'lqinli pechga chiroyli va zamonaviy ko‘rinish beradi. 
                To‘lqinli uch teng tarqatish tizimi pishirish kamerasini bir tekis isitadi, taomga har 
                tomondan kirib boradi. Buning yordamida taomlar bir xil pishadi. Bardoshli biotermik 
                qoplamani tozalash oson, tirnalmaydi va antibakterial."
        ]);

        ProductVariant::create([
            'product_id' => $SamsungMicrowave->id,
            'name' => "Mikroto`lqinli Pech Samsung ME83KRW-1KBW",
            'sku' => 'SAMSUNG-ME83KRW-MICROWAVE',
            'price' => 2300000,
            'stock' => 20
        ]);

        $SamsungMicrowave->attributeValue()->attach([
            $SamsungMicrowavePower->id,
            $SamsungMicrowaveCap->id
        ]);


        // ELECTRIC KETTLE. Tefal KO693110
        $TefalKettlePower = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'power'))->where('value', '1800 W')->first();
        $TefalKettleCap = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'capacity'))->where('value', '1.5 L')->first(); 

        $TefalKettle = Product::create([
            'category_id' => $SmallAppliancesCat->id,
            'brand_id' => $TefalBrand->id,
            'name' => "Elektr Choynak Tefal KO693110",
            'slug' => "elektr-choynak-tefal-ko693110",
            'price' => 1300000,
            'description' => "Tefal KO693110 elektr choynak yuqori sifatli oziq-ovqat plastmassasidan 
                tayyorlangan. Choynak cho'kindiga qarshi filtr bilan jihozlangan, shuning uchun suvingiz 
                doimo toza bo‘ladi. Choynak korpusining ichki qismida suv darajasi ko‘rsatkichi mavjud. 
                U o‘rnatilgan elektron displey bilan jihozlangan bo‘lib, choynakdagi suv haroratini 
                ko‘rsatadi. Bundan tashqari, 5 ta harorat sozlamalari mavjud. Isitish elementi pastki 
                qismining zanglamaydigan po‘lat ostida yashiringan. Chiroyli dizayn choy va qahvani 
                sevuvchilar uchun ayni muddao. Ushbu model haddan tashqari qizib ketishdan himoya qilingan, 
                qaynaganda, suv yo‘q bo‘lganda yoki choynak stenddan olinganda avtomatik ravishda o‘chiradi."
        ]);

        ProductVariant::create([
            'product_id' => $TefalKettle->id,
            'name' => "Elektr Choynak Tefal KO693110",
            'sku' => 'TEFAL-KO693110-KETTLE',
            'price' => 1300000,
            'stock' => 20
        ]);

        $TefalKettle->attributeValue()->attach([
            $TefalKettlePower->id,
            $TefalKettleCap->id
        ]); 


        // Electric Kettle Braun WK5205BK
        $BraunKettlePower = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'power'))->where('value', '1800 W')->first();
        $BraunKettleCap = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'capacity'))->where('value', '1.5 L')->first(); 

        $BraunKettle = Product::create([
            'category_id' => $SmallAppliancesCat->id,
            'brand_id' => $BraunBrand->id,
            'name' => "Elektr Choynak Braun WK5205BK",
            'slug' => "elektr-choynak-braun-wk5205bk",
            'price' => 900000,
            'description' => "Braun WK5205BK elektr choynagi — bu texnologik va ishonchli qurilma bo‘lib, 
                uyda yoki ofisda suvni tez qaynatish uchun mo‘ljallangan. 2200 Vt quvvatga ega model 
                suyuqlikni juda qisqa vaqt ichida qaynash holatiga yetkazadi, bu esa ayniqsa ertalabki 
                shoshilinch paytlarda yoki mehmon kutib olayotganda juda qulay. 1.7 litr hajmdagi katta 
                idish bir nechta chashka ichimlikni bir vaqtning o‘zida tayyorlash imkonini beradi, bu esa 
                vaqtingizni tejaydi va kundalik hayotingizda qulaylik yaratadi. Korpusga o‘rnatilgan shaffof 
                ko‘rsatkich orqali suv miqdorini ko‘z bilan baholash mumkin, bu esa to‘lib ketish ehtimolini 
                kamaytiradi. Tashqi qoplamasi metall materialdan yasalgan bo‘lib, u tashqi zarbalarga va yuqori 
                haroratga chidamli. Zamonaviy kumushrang dizayn esa qurilmaga nafis ko‘rinish bag‘ishlaydi 
                va u har qanday oshxona muhitiga mos tushadi."
        ]);

        ProductVariant::create([
            'product_id' => $BraunKettle->id,
            'name' => "Elektr Choynak Braun WK5205BK",
            'sku' => 'BRAUN-WK5205BK-KETTLE',
            'price' => 900000,
            'stock' => 20
        ]);

        $BraunKettle->attributeValue()->attach([
            $BraunKettlePower->id,
            $BraunKettleCap->id
        ]);


        // HAIR DRYER. Polaris PHD 2289AC
        $PolarisDryerPower = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'power'))->where('value', '2200 W')->first();
        $PolarisDryerColor = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'color'))->where('value', 'Black')->first();

        $PolarisDryer = Product::create([
            'category_id' => $SmallAppliancesCat->id,
            'brand_id' => $PolarisBrand->id,
            'name' => "Soch Quritgich Polaris PHD 2289AC",
            'slug' => "soch-quritgich-polaris-phd-2289ac",
            'price' => 550000,
            'description' => "Polaris PHD 2289AC soch quritgich - 2,2 kW/soat quvvat va 6 harorat 
                rejimiga ega bo‘lib, tez va samarali o‘rnatishni ta’minlaydi. AS motor tufayli 
                fen kuchli havo oqimini hosil qilib, quritish vaqtini qisqartiradi. IonDefence 
                texnologiyasi bilan ionlashtirish statik elektrni kamaytiradi va sochlarni himoya 
                qiladi, ularning tabiiy namligini saqlaydi va tarashni osonlashtiradi."
        ]);

        ProductVariant::create([
            'product_id' => $PolarisDryer->id,
            'name' => "Soch Quritgich Polaris PHD 2289AC",
            'sku' => 'POLARIS-PHD2289AC-HAIRDRYER',
            'price' => 550000,
            'stock' => 20
        ]);

        $PolarisDryer->attributeValue()->attach([
            $PolarisDryerPower->id,
            $PolarisDryerColor->id
        ]);


        // Hair Dryer Philips HPS920/00
        $PhilipsDryerPower = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'power'))->where('value', '2300 W')->first();
        $PhilipsDryerColor = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'color'))->where('value', 'Black')->first();

        $PhilipsDryer = Product::create([
            'category_id' => $SmallAppliancesCat->id,
            'brand_id' => $PhilipsBrand->id,
            'name' => "Soch Quritgich Philips HPS920-00",
            'slug' => "soch-quritgich-philips-hps920-00",
            'price' => 2000000,
            'description' => "Fen Philips HPS920/00 – bu tez quritish va chiroyli soch turmaklash uchun 
                yaratilgan zamonaviy qurilma. 2300 Vt quvvati kuchli havo oqimini ta’minlab, qalin va 
                uzun sochlarni ham osonlik bilan quritishga yordam beradi. Harorat darajasi 210 °C gacha 
                yetadi, bu esa uy sharoitida mustahkam natija olish imkonini beradi."
        ]);

        ProductVariant::create([
            'product_id' => $PhilipsDryer->id,
            'name' => "Soch Quritgich Philips HPS920-00",
            'sku' => 'PHILIPS-HPS920-HAIRDRYER',
            'price' => 2000000,
            'stock' => 20
        ]);

        $PhilipsDryer->attributeValue()->attach([
            $PhilipsDryerPower->id,
            $PhilipsDryerColor->id
        ]);
    }
}
