<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;
use App\Models\State;

class CountriesAndStatesSeeder extends Seeder
{
    public function run(): void
    {
        $countriesData = [
            ['name' => 'Afghanistan', 'code' => 'AF', 'flag' => '🇦🇫', 'states' => ['Kabul', 'Kandahar', 'Herat', 'Mazar-i-Sharif']],
            ['name' => 'Albania', 'code' => 'AL', 'flag' => '🇦🇱', 'states' => ['Tirana', 'Durrës', 'Vlorë', 'Shkodër']],
            ['name' => 'Algeria', 'code' => 'DZ', 'flag' => '🇩🇿', 'states' => ['Algiers', 'Oran', 'Constantine', 'Annaba']],
            ['name' => 'Argentina', 'code' => 'AR', 'flag' => '🇦🇷', 'states' => ['Buenos Aires', 'Córdoba', 'Santa Fe', 'Mendoza']],
            ['name' => 'Australia', 'code' => 'AU', 'flag' => '🇦🇺', 'states' => ['New South Wales', 'Victoria', 'Queensland', 'Western Australia', 'South Australia', 'Tasmania']],
            ['name' => 'Austria', 'code' => 'AT', 'flag' => '🇦🇹', 'states' => ['Vienna', 'Lower Austria', 'Upper Austria', 'Styria']],
            ['name' => 'Bangladesh', 'code' => 'BD', 'flag' => '🇧🇩', 'states' => ['Dhaka', 'Chittagong', 'Rajshahi', 'Khulna']],
            ['name' => 'Belgium', 'code' => 'BE', 'flag' => '🇧🇪', 'states' => ['Brussels', 'Flanders', 'Wallonia']],
            ['name' => 'Brazil', 'code' => 'BR', 'flag' => '🇧🇷', 'states' => ['São Paulo', 'Rio de Janeiro', 'Minas Gerais', 'Bahia', 'Paraná']],
            ['name' => 'Bulgaria', 'code' => 'BG', 'flag' => '🇧🇬', 'states' => ['Sofia', 'Plovdiv', 'Varna', 'Burgas']],
            [
                'name' => 'Canada',
                'code' => 'CA',
                'flag' => '🇨🇦',
                'states' => [
                    'Alberta', 'British Columbia', 'Manitoba', 'New Brunswick', 'Newfoundland and Labrador',
                    'Northwest Territories', 'Nova Scotia', 'Nunavut', 'Ontario', 'Prince Edward Island',
                    'Quebec', 'Saskatchewan', 'Yukon'
                ]
            ],
            ['name' => 'Chile', 'code' => 'CL', 'flag' => '🇨🇱', 'states' => ['Santiago', 'Valparaíso', 'Biobío', 'Araucanía']],
            ['name' => 'China', 'code' => 'CN', 'flag' => '🇨🇳', 'states' => ['Beijing', 'Shanghai', 'Guangdong', 'Sichuan', 'Henan']],
            ['name' => 'Colombia', 'code' => 'CO', 'flag' => '🇨🇴', 'states' => ['Bogotá', 'Antioquia', 'Valle del Cauca', 'Atlántico']],
            ['name' => 'Croatia', 'code' => 'HR', 'flag' => '🇭🇷', 'states' => ['Zagreb', 'Split-Dalmatia', 'Primorje-Gorski Kotar', 'Istria']],
            ['name' => 'Czech Republic', 'code' => 'CZ', 'flag' => '🇨🇿', 'states' => ['Prague', 'Central Bohemia', 'South Moravia', 'Moravian-Silesia']],
            ['name' => 'Denmark', 'code' => 'DK', 'flag' => '🇩🇰', 'states' => ['Capital Region', 'Central Denmark', 'North Denmark', 'Zealand', 'Southern Denmark']],
            ['name' => 'Egypt', 'code' => 'EG', 'flag' => '🇪🇬', 'states' => ['Cairo', 'Alexandria', 'Giza', 'Shubra El Kheima']],
            ['name' => 'Finland', 'code' => 'FI', 'flag' => '🇫🇮', 'states' => ['Uusimaa', 'Pirkanmaa', 'Varsinais-Suomi', 'North Ostrobothnia']],
            ['name' => 'France', 'code' => 'FR', 'flag' => '🇫🇷', 'states' => ['Île-de-France', 'Auvergne-Rhône-Alpes', 'Nouvelle-Aquitaine', 'Occitanie']],
            ['name' => 'Germany', 'code' => 'DE', 'flag' => '🇩🇪', 'states' => ['North Rhine-Westphalia', 'Bavaria', 'Baden-Württemberg', 'Lower Saxony']],
            ['name' => 'Ghana', 'code' => 'GH', 'flag' => '🇬🇭', 'states' => ['Greater Accra', 'Ashanti', 'Western', 'Eastern']],
            ['name' => 'Greece', 'code' => 'GR', 'flag' => '🇬🇷', 'states' => ['Attica', 'Central Macedonia', 'Thessaly', 'Western Greece']],
            ['name' => 'Hungary', 'code' => 'HU', 'flag' => '🇭🇺', 'states' => ['Budapest', 'Pest', 'Borsod-Abaúj-Zemplén', 'Győr-Moson-Sopron']],
            ['name' => 'Iceland', 'code' => 'IS', 'flag' => '🇮🇸', 'states' => ['Capital Region', 'Southern Peninsula', 'Western Region', 'Westfjords']],
            ['name' => 'India', 'code' => 'IN', 'flag' => '🇮🇳', 'states' => ['Maharashtra', 'Uttar Pradesh', 'Bihar', 'West Bengal', 'Madhya Pradesh']],
            ['name' => 'Indonesia', 'code' => 'ID', 'flag' => '🇮🇩', 'states' => ['Java', 'Sumatra', 'Kalimantan', 'Sulawesi']],
            ['name' => 'Iran', 'code' => 'IR', 'flag' => '🇮🇷', 'states' => ['Tehran', 'Razavi Khorasan', 'Isfahan', 'Khuzestan']],
            ['name' => 'Iraq', 'code' => 'IQ', 'flag' => '🇮🇶', 'states' => ['Baghdad', 'Basra', 'Nineveh', 'Erbil']],
            ['name' => 'Ireland', 'code' => 'IE', 'flag' => '🇮🇪', 'states' => ['Leinster', 'Munster', 'Connacht', 'Ulster']],
            ['name' => 'Israel', 'code' => 'IL', 'flag' => '🇮🇱', 'states' => ['Jerusalem', 'Tel Aviv', 'Haifa', 'Rishon LeZion']],
            ['name' => 'Italy', 'code' => 'IT', 'flag' => '🇮🇹', 'states' => ['Lombardy', 'Lazio', 'Campania', 'Sicily']],
            ['name' => 'Japan', 'code' => 'JP', 'flag' => '🇯🇵', 'states' => ['Tokyo', 'Osaka', 'Kanagawa', 'Aichi']],
            ['name' => 'Jordan', 'code' => 'JO', 'flag' => '🇯🇴', 'states' => ['Amman', 'Zarqa', 'Irbid', 'Russeifa']],
            ['name' => 'Kazakhstan', 'code' => 'KZ', 'flag' => '🇰🇿', 'states' => ['Almaty', 'Nur-Sultan', 'Shymkent', 'Aktobe']],
            ['name' => 'Kenya', 'code' => 'KE', 'flag' => '🇰🇪', 'states' => ['Nairobi', 'Mombasa', 'Nakuru', 'Eldoret']],
            ['name' => 'Kuwait', 'code' => 'KW', 'flag' => '🇰🇼', 'states' => ['Al Asimah', 'Hawalli', 'Al Farwaniyah', 'Mubarak Al-Kabeer']],
            ['name' => 'Latvia', 'code' => 'LV', 'flag' => '🇱🇻', 'states' => ['Riga', 'Daugavpils', 'Liepāja', 'Jelgava']],
            ['name' => 'Lebanon', 'code' => 'LB', 'flag' => '🇱🇧', 'states' => ['Beirut', 'Mount Lebanon', 'North Lebanon', 'South Lebanon']],
            ['name' => 'Libya', 'code' => 'LY', 'flag' => '🇱🇾', 'states' => ['Tripoli', 'Benghazi', 'Misrata', 'Tarhuna']],
            ['name' => 'Lithuania', 'code' => 'LT', 'flag' => '🇱🇹', 'states' => ['Vilnius', 'Kaunas', 'Klaipėda', 'Šiauliai']],
            ['name' => 'Luxembourg', 'code' => 'LU', 'flag' => '🇱🇺', 'states' => ['Luxembourg', 'Esch-sur-Alzette', 'Differdange', 'Dudelange']],
            ['name' => 'Malaysia', 'code' => 'MY', 'flag' => '🇲🇾', 'states' => ['Selangor', 'Johor', 'Sabah', 'Sarawak']],
            ['name' => 'Mexico', 'code' => 'MX', 'flag' => '🇲🇽', 'states' => ['Mexico City', 'State of Mexico', 'Jalisco', 'Nuevo León']],
            ['name' => 'Morocco', 'code' => 'MA', 'flag' => '🇲🇦', 'states' => ['Casablanca', 'Rabat', 'Fès', 'Marrakech']],
            ['name' => 'Netherlands', 'code' => 'NL', 'flag' => '🇳🇱', 'states' => ['North Holland', 'South Holland', 'North Brabant', 'Gelderland']],
            ['name' => 'New Zealand', 'code' => 'NZ', 'flag' => '🇳🇿', 'states' => ['Auckland', 'Canterbury', 'Wellington', 'Waikato']],
            [
                'name' => 'Nigeria',
                'code' => 'NG',
                'flag' => '🇳🇬',
                'states' => [
                    'Abia', 'Adamawa', 'Akwa Ibom', 'Anambra', 'Bauchi', 'Bayelsa', 'Benue', 'Borno',
                    'Cross River', 'Delta', 'Ebonyi', 'Edo', 'Ekiti', 'Enugu', 'Gombe', 'Imo', 'Jigawa',
                    'Kaduna', 'Kano', 'Katsina', 'Kebbi', 'Kogi', 'Kwara', 'Lagos', 'Nasarawa', 'Niger',
                    'Ogun', 'Ondo', 'Osun', 'Oyo', 'Plateau', 'Rivers', 'Sokoto', 'Taraba', 'Yobe', 'Zamfara',
                    'Federal Capital Territory'
                ]
            ],
            ['name' => 'Norway', 'code' => 'NO', 'flag' => '🇳🇴', 'states' => ['Oslo', 'Viken', 'Rogaland', 'Møre og Romsdal']],
            ['name' => 'Pakistan', 'code' => 'PK', 'flag' => '🇵🇰', 'states' => ['Punjab', 'Sindh', 'Khyber Pakhtunkhwa', 'Balochistan']],
            ['name' => 'Peru', 'code' => 'PE', 'flag' => '🇵🇪', 'states' => ['Lima', 'Arequipa', 'La Libertad', 'Piura']],
            ['name' => 'Philippines', 'code' => 'PH', 'flag' => '🇵🇭', 'states' => ['Metro Manila', 'Calabarzon', 'Central Luzon', 'Western Visayas']],
            ['name' => 'Poland', 'code' => 'PL', 'flag' => '🇵🇱', 'states' => ['Masovian', 'Silesian', 'Greater Poland', 'Lesser Poland']],
            ['name' => 'Portugal', 'code' => 'PT', 'flag' => '🇵🇹', 'states' => ['Lisbon', 'Porto', 'Setúbal', 'Braga']],
            ['name' => 'Qatar', 'code' => 'QA', 'flag' => '🇶🇦', 'states' => ['Doha', 'Al Rayyan', 'Al Wakrah', 'Al Khor']],
            ['name' => 'Romania', 'code' => 'RO', 'flag' => '🇷🇴', 'states' => ['Bucharest', 'Cluj', 'Timiș', 'Iași']],
            ['name' => 'Russia', 'code' => 'RU', 'flag' => '🇷🇺', 'states' => ['Moscow', 'Saint Petersburg', 'Novosibirsk', 'Yekaterinburg']],
            ['name' => 'Saudi Arabia', 'code' => 'SA', 'flag' => '🇸🇦', 'states' => ['Riyadh', 'Makkah', 'Eastern Province', 'Asir']],
            ['name' => 'Singapore', 'code' => 'SG', 'flag' => '🇸🇬', 'states' => ['Central Region', 'East Region', 'North Region', 'Northeast Region', 'West Region']],
            ['name' => 'Slovakia', 'code' => 'SK', 'flag' => '🇸🇰', 'states' => ['Bratislava', 'Košice', 'Prešov', 'Žilina']],
            ['name' => 'Slovenia', 'code' => 'SI', 'flag' => '🇸🇮', 'states' => ['Central Slovenia', 'Drava', 'Savinja', 'Southeast Slovenia']],
            ['name' => 'South Africa', 'code' => 'ZA', 'flag' => '🇿🇦', 'states' => ['Gauteng', 'KwaZulu-Natal', 'Western Cape', 'Eastern Cape']],
            ['name' => 'South Korea', 'code' => 'KR', 'flag' => '🇰🇷', 'states' => ['Seoul', 'Busan', 'Incheon', 'Daegu']],
            ['name' => 'Spain', 'code' => 'ES', 'flag' => '🇪🇸', 'states' => ['Andalusia', 'Catalonia', 'Madrid', 'Valencia']],
            ['name' => 'Sweden', 'code' => 'SE', 'flag' => '🇸🇪', 'states' => ['Stockholm', 'Västra Götaland', 'Skåne', 'Östergötland']],
            ['name' => 'Switzerland', 'code' => 'CH', 'flag' => '🇨🇭', 'states' => ['Zurich', 'Bern', 'Vaud', 'Aargau']],
            ['name' => 'Thailand', 'code' => 'TH', 'flag' => '🇹🇭', 'states' => ['Bangkok', 'Nonthaburi', 'Nakhon Ratchasima', 'Chiang Mai']],
            ['name' => 'Turkey', 'code' => 'TR', 'flag' => '🇹🇷', 'states' => ['Istanbul', 'Ankara', 'İzmir', 'Bursa']],
            ['name' => 'Ukraine', 'code' => 'UA', 'flag' => '🇺🇦', 'states' => ['Kyiv', 'Kharkiv', 'Odesa', 'Dnipro']],
            [
                'name' => 'United Kingdom',
                'code' => 'GB',
                'flag' => '🇬🇧',
                'states' => [
                    'England', 'Scotland', 'Wales', 'Northern Ireland'
                ]
            ],
            [
                'name' => 'United States',
                'code' => 'US',
                'flag' => '🇺🇸',
                'states' => [
                    'Alabama', 'Alaska', 'Arizona', 'Arkansas', 'California', 'Colorado', 'Connecticut', 'Delaware',
                    'Florida', 'Georgia', 'Hawaii', 'Idaho', 'Illinois', 'Indiana', 'Iowa', 'Kansas', 'Kentucky',
                    'Louisiana', 'Maine', 'Maryland', 'Massachusetts', 'Michigan', 'Minnesota', 'Mississippi',
                    'Missouri', 'Montana', 'Nebraska', 'Nevada', 'New Hampshire', 'New Jersey', 'New Mexico',
                    'New York', 'North Carolina', 'North Dakota', 'Ohio', 'Oklahoma', 'Oregon', 'Pennsylvania',
                    'Rhode Island', 'South Carolina', 'South Dakota', 'Tennessee', 'Texas', 'Utah', 'Vermont',
                    'Virginia', 'Washington', 'West Virginia', 'Wisconsin', 'Wyoming'
                ]
            ],
            ['name' => 'Uruguay', 'code' => 'UY', 'flag' => '🇺🇾', 'states' => ['Montevideo', 'Canelones', 'Maldonado', 'Salto']],
            ['name' => 'Venezuela', 'code' => 'VE', 'flag' => '🇻🇪', 'states' => ['Capital District', 'Zulia', 'Miranda', 'Lara']],
            ['name' => 'Vietnam', 'code' => 'VN', 'flag' => '🇻🇳', 'states' => ['Ho Chi Minh City', 'Hanoi', 'Haiphong', 'Da Nang']],
            ['name' => 'Zimbabwe', 'code' => 'ZW', 'flag' => '🇿🇼', 'states' => ['Harare', 'Bulawayo', 'Chitungwiza', 'Mutare']]
        ];

        foreach ($countriesData as $countryData) {
            $country = Country::create([
                'name' => $countryData['name'],
                'code' => $countryData['code'],
                'flag' => $countryData['flag']
            ]);

            foreach ($countryData['states'] as $stateName) {
                State::create([
                    'name' => $stateName,
                    'country_id' => $country->id
                ]);
            }
        }
    }
}