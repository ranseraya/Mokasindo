@extends('layouts.app')

@section('content')
    <section class="relative bg-gradient-to-br from-indigo-600 via-indigo-700 to-purple-800 text-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-[7rem]">
            <div class="text-center">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">Daftar Akun</h1>
                <p class="text-indigo-100 max-w-2xl mx-auto">Buat akun untuk memulai lelang kendaraan Anda. Lengkapi data dan alamat dengan benar.</p>
            </div>
        </div>

        <div class="absolute bottom-0 w-full">
            <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full">
                <path d="M0 0L60 10C120 20 240 40 360 46.7C480 53 600 47 720 43.3C840 40 960 40 1080 46.7C1200 53 1320 67 1380 73.3L1440 80V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0V0Z" fill="#F9FAFB"/>
            </svg>
        </div>
    </section>

    <section class="py-12 bg-gray-50">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-2xl p-8 md:p-10">
                @if(session('status'))
                    <div class="mb-4 p-3 rounded bg-green-50 border border-green-100 text-green-700">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ url('/register') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama lengkap</label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                               placeholder="Nama lengkap (sesuai KTP)"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm px-4 py-3 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}" required
                                   placeholder="email@domain.com"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm px-4 py-3 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nomor HP</label>
                            <input type="tel" name="phone" value="{{ old('phone') }}" required
                                   placeholder="0812xxxxxxxx (tanpa +62)"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm px-4 py-3 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('phone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Password</label>
                            <input type="password" name="password" required
                                   placeholder="Minimal 6 karakter"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm px-4 py-3 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('password') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" required
                                   placeholder="Ketik ulang password"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm px-4 py-3 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Provinsi</label>
                            <select name="province_id" required
                                    class="mt-1 block w-full rounded-md border-gray-300 bg-white shadow-sm px-4 py-3 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="" disabled selected>Pilih provinsi</option>
                                {{-- Populate options dinamis dari controller --}}
                            </select>
                            @error('province_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Kota/Kabupaten</label>
                            <select name="city_id" required
                                    class="mt-1 block w-full rounded-md border-gray-300 bg-white shadow-sm px-4 py-3 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="" disabled selected>Pilih kota/kabupaten</option>
                                {{-- Populate options dinamis berdasarkan provinsi --}}
                            </select>
                            @error('city_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Kecamatan</label>
                            <select name="district_id" required
                                    class="mt-1 block w-full rounded-md border-gray-300 bg-white shadow-sm px-4 py-3 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="" disabled selected>Pilih kecamatan</option>
                                {{-- Populate options dinamis berdasarkan kota --}}
                            </select>
                            @error('district_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Kelurahan</label>
                            <select name="sub_district_id" required
                                    class="mt-1 block w-full rounded-md border-gray-300 bg-white shadow-sm px-4 py-3 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="" disabled selected>Pilih kelurahan</option>
                                {{-- Populate options dinamis berdasarkan kecamatan --}}
                            </select>
                            @error('sub_district_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Kode Pos</label>
                            <input type="text" name="postal_code" value="{{ old('postal_code') }}" required
                                   placeholder="Contoh: 12345"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm px-4 py-3 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('postal_code') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Alamat lengkap</label>
                            <textarea name="address" rows="3" required
                                      placeholder="Alamat jalan, nomor gedung, RT/RW, dsb"
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm px-4 py-3 text-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('address') }}</textarea>
                            @error('address') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit"
                                class="w-full inline-flex items-center justify-center rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 font-semibold shadow">
                            Daftar
                        </button>
                    </div>

                    <div class="text-center text-sm text-gray-500">
                        Sudah punya akun? <a href="{{ url('/login') }}" class="text-indigo-600 hover:underline">Login</a>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- populate provinces and regencies from external API -->
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const provinceSelect = document.querySelector('select[name="province_id"]');
        const citySelect = document.querySelector('select[name="city_id"]');
        const districtSelect = document.querySelector('select[name="district_id"]');
        const subDistrictSelect = document.querySelector('select[name="sub_district_id"]');

        const oldProvince = @json(old('province_id'));
        const oldCity = @json(old('city_id'));
        const oldDistrict = @json(old('district_id'));
        const oldSubDistrict = @json(old('sub_district_id'));

        function getId(p){ return p.id ?? p.code ?? p.kode ?? p.province_id ?? p.kd ?? p.name ?? ''; }
        function getName(p){ return p.name ?? p.province ?? p.nama ?? String(p); }

        function setLoading(select, text){
            if(!select) return;
            select.innerHTML = `<option value="" disabled selected>${text}</option>`;
        }

        function clearSelect(select, placeholder){
            if(!select) return;
            select.innerHTML = `<option value="" disabled selected>${placeholder}</option>`;
        }

        // load provinces
        if(provinceSelect){
            setLoading(provinceSelect, 'Memuat provinsi...');
            fetch('https://kanglerian.my.id/api-wilayah-indonesia/api/provinces.json')
                .then(r => r.json())
                .then(provinces => {
                    if(!Array.isArray(provinces)){
                        console.error('Unexpected provinces format', provinces);
                        setLoading(provinceSelect, 'Data provinsi tidak valid');
                        return;
                    }
                    provinces.sort((a,b) => getName(a).localeCompare(getName(b), 'id'));
                    provinceSelect.innerHTML = '<option value="" disabled selected>Pilih provinsi</option>';
                    provinces.forEach(p => {
                        const id = getId(p);
                        const name = getName(p);
                        const opt = document.createElement('option');
                        opt.value = id;
                        opt.textContent = name;
                        if(oldProvince && String(oldProvince) === String(id)) opt.selected = true;
                        provinceSelect.appendChild(opt);
                    });

                    // if oldProvince exists (form returned), load its regencies
                    if(oldProvince && citySelect){
                        loadRegencies(String(oldProvince));
                    }
                })
                .catch(err => {
                    console.error('Gagal memuat provinsi:', err);
                    setLoading(provinceSelect, 'Gagal memuat provinsi');
                });
        }

        // load regencies when province changes
        function loadRegencies(provinceId){
            if(!citySelect) return;
            clearSelect(citySelect, 'Memuat kota/kabupaten...');
            // clear downstream selects
            clearSelect(districtSelect, 'Pilih kecamatan');
            clearSelect(subDistrictSelect, 'Pilih kelurahan');

            fetch(`https://kanglerian.my.id/api-wilayah-indonesia/api/regencies/${provinceId}.json`)
                .then(r => r.json())
                .then(regencies => {
                    if(!Array.isArray(regencies)){
                        console.error('Unexpected regencies format', regencies);
                        clearSelect(citySelect, 'Data kota/kabupaten tidak valid');
                        return;
                    }
                    regencies.sort((a,b) => (a.name ?? '').localeCompare(b.name ?? '', 'id'));
                    citySelect.innerHTML = '<option value="" disabled selected>Pilih kota/kabupaten</option>';
                    regencies.forEach(r => {
                        const opt = document.createElement('option');
                        opt.value = r.id ?? r.kabupaten_id ?? r.code ?? r.name;
                        opt.textContent = r.name ?? r.title ?? String(r);
                        if(oldCity && String(oldCity) === String(opt.value)) opt.selected = true;
                        citySelect.appendChild(opt);
                    });

                    // if oldCity exists, load districts for that city
                    if(oldCity){
                        loadDistricts(String(oldCity));
                    }
                })
                .catch(err => {
                    console.error('Gagal memuat kota/kabupaten:', err);
                    clearSelect(citySelect, 'Gagal memuat kota/kabupaten');
                });
        }

        // load districts (kecamatan) when city/regency selected
        function loadDistricts(cityId){
            if(!districtSelect) return;
            clearSelect(districtSelect, 'Memuat kecamatan...');
            // clear downstream select
            clearSelect(subDistrictSelect, 'Pilih kelurahan');

            fetch(`https://kanglerian.my.id/api-wilayah-indonesia/api/districts/${cityId}.json`)
                .then(r => r.json())
                .then(districts => {
                    if(!Array.isArray(districts)){
                        console.error('Unexpected districts format', districts);
                        clearSelect(districtSelect, 'Data kecamatan tidak valid');
                        return;
                    }
                    districts.sort((a,b) => (a.name ?? '').localeCompare(b.name ?? '', 'id'));
                    districtSelect.innerHTML = '<option value="" disabled selected>Pilih kecamatan</option>';
                    districts.forEach(d => {
                        const opt = document.createElement('option');
                        opt.value = d.id ?? d.district_id ?? d.code ?? d.name;
                        opt.textContent = d.name ?? d.title ?? String(d);
                        if(oldDistrict && String(oldDistrict) === String(opt.value)) opt.selected = true;
                        districtSelect.appendChild(opt);
                    });

                    // if oldDistrict exists, load villages for that district
                    if(oldDistrict){
                        loadVillages(String(oldDistrict));
                    }
                })
                .catch(err => {
                    console.error('Gagal memuat kecamatan:', err);
                    clearSelect(districtSelect, 'Gagal memuat kecamatan');
                });
        }

        // NEW: load villages (kelurahan) when district selected
        function loadVillages(districtId){
            if(!subDistrictSelect) return;
            clearSelect(subDistrictSelect, 'Memuat kelurahan...');

            fetch(`https://kanglerian.my.id/api-wilayah-indonesia/api/villages/${districtId}.json`)
                .then(r => r.json())
                .then(villages => {
                    if(!Array.isArray(villages)){
                        console.error('Unexpected villages format', villages);
                        clearSelect(subDistrictSelect, 'Data kelurahan tidak valid');
                        return;
                    }
                    villages.sort((a,b) => (a.name ?? '').localeCompare(b.name ?? '', 'id'));
                    subDistrictSelect.innerHTML = '<option value="" disabled selected>Pilih kelurahan</option>';
                    villages.forEach(v => {
                        const opt = document.createElement('option');
                        opt.value = v.id ?? v.village_id ?? v.code ?? v.name;
                        opt.textContent = v.name ?? v.title ?? String(v);
                        if(oldSubDistrict && String(oldSubDistrict) === String(opt.value)) opt.selected = true;
                        subDistrictSelect.appendChild(opt);
                    });
                })
                .catch(err => {
                    console.error('Gagal memuat kelurahan:', err);
                    clearSelect(subDistrictSelect, 'Gagal memuat kelurahan');
                });
        }

        // attach change listener to province select
        if(provinceSelect){
            provinceSelect.addEventListener('change', function(){
                const val = this.value;
                if(val) loadRegencies(val);
            });
        }

        // attach change listener to city select to load districts
        if(citySelect){
            citySelect.addEventListener('change', function(){
                const val = this.value;
                if(val) loadDistricts(val);
            });
        }

        // attach change listener to district select to load villages
        if(districtSelect){
            districtSelect.addEventListener('change', function(){
                const val = this.value;
                if(val) loadVillages(val);
            });
        }
    });
    </script>
@endsection
