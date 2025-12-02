@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    
    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Pengaturan Profil</h1>
            <p class="text-gray-500 text-sm mt-1">Kelola informasi profil Anda untuk mengamankan akun</p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        
        <div class="px-6 py-5 border-b border-gray-100 bg-gray-50">
            <h2 class="text-lg font-bold text-gray-900">Edit Data Diri</h2>
            <p class="text-xs text-gray-500 mt-1">Perbarui foto dan informasi alamat Anda.</p>
        </div>

        @if(session('success'))
            <div class="px-6 pt-6">
                <div class="bg-green-50 text-green-800 px-4 py-3 rounded-lg text-sm flex items-center gap-2 border border-green-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            @method('PATCH')

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                
                <div class="md:col-span-1">
                    <div class="flex flex-col items-center text-center p-6 border border-gray-100 rounded-xl bg-gray-50">
                        <div class="relative group h-32 w-32 mb-4">
                            <div class="h-32 w-32 rounded-full bg-white overflow-hidden border-4 border-white shadow-md">
                                @if($user->avatar)
                                    <img id="avatarPreview" src="{{ asset('storage/' . $user->avatar) }}" class="h-full w-full object-cover">
                                @else
                                    <img id="avatarPreview" src="#" class="h-full w-full object-cover hidden">
                                    <div id="avatarPlaceholder" class="h-full w-full flex items-center justify-center bg-indigo-100 text-indigo-500 font-bold text-4xl">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                @endif
                            </div>
                            <label for="avatar" class="absolute bottom-1 right-1 bg-indigo-600 p-2 rounded-full shadow-lg border-2 border-white cursor-pointer hover:bg-indigo-700 transition text-white">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </label>
                            <input type="file" id="avatar" name="avatar" class="hidden" accept="image/*" onchange="previewImage(this)">
                        </div>
                        <h3 class="font-bold text-gray-900">{{ $user->name }}</h3>
                        <p class="text-sm text-gray-500 mb-4">{{ $user->email }}</p>
                    </div>
                </div>

                <div class="md:col-span-2 space-y-6">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="col-span-2 md:col-span-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 px-4 py-2.5">
                        </div>
                        <div class="col-span-2 md:col-span-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" value="{{ $user->email }}" disabled class="w-full rounded-lg border-gray-200 bg-gray-50 text-gray-500 px-4 py-2.5 cursor-not-allowed">
                        </div>
                        <div class="col-span-2 md:col-span-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1">No. WhatsApp</label>
                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 px-4 py-2.5">
                        </div>
                    </div>

                    <hr class="border-gray-100">

                    <div>
                        <h3 class="text-sm font-bold text-gray-900 mb-4 flex items-center gap-2">Alamat Lengkap</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1 uppercase tracking-wide">Provinsi</label>
                                <select name="province_id" id="province_id" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 px-4 py-2.5 bg-white">
                                    <option value="" disabled selected>Pilih Provinsi</option>
                                    @foreach($provinces as $province)
                                        <option value="{{ $province->id }}" 
                                            {{ old('province_id', $user->province_id) == $province->id ? 'selected' : '' }}>
                                            {{ $province->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1 uppercase tracking-wide">Kota/Kabupaten</label>
                                <select name="city_id" id="city_id" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 px-4 py-2.5 bg-white">
                                    <option value="" disabled selected>Pilih Kota</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1 uppercase tracking-wide">Kecamatan</label>
                                <select name="district_id" id="district_id" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 px-4 py-2.5 bg-white">
                                    <option value="" disabled selected>Pilih Kecamatan</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1 uppercase tracking-wide">Kelurahan</label>
                                <select name="sub_district_id" id="sub_district_id" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 px-4 py-2.5 bg-white">
                                    <option value="" disabled selected>Pilih Kelurahan</option>
                                </select>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-xs font-medium text-gray-500 mb-1 uppercase tracking-wide">Kode Pos</label>
                                <input type="text" name="postal_code" value="{{ old('postal_code', $user->postal_code) }}" class="w-full md:w-1/3 rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 px-4 py-2.5" placeholder="Contoh: 12345">
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-xs font-medium text-gray-500 mb-1 uppercase tracking-wide">Jalan / Detail Rumah</label>
                                <textarea name="address" rows="3" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 px-4 py-2.5">{{ old('address', $user->address) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end pt-4 border-t border-gray-100">
                        <button type="submit" class="bg-indigo-600 text-white px-8 py-3 rounded-lg font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-200">
                            Simpan Perubahan
                        </button>
                    </div>
                </div> 
            </div>
        </form>
    </div>
</div>

<script>
    // 1. Preview Image (Live Update ke Form & Navbar)
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function(e) {
                document.getElementById('avatarPlaceholder')?.classList.add('hidden');
                
                // Tampilkan gambar preview besar
                const mainPreview = document.getElementById('avatarPreview');
                if (mainPreview) {
                    mainPreview.src = e.target.result;
                    mainPreview.classList.remove('hidden');
                }

                document.getElementById('nav-avatar-initial')?.classList.add('hidden');
                document.getElementById('nav-avatar-initial')?.classList.remove('flex'); 

                // Tampilkan gambar di navbar
                const navPreview = document.getElementById('nav-avatar-img');
                if (navPreview) {
                    navPreview.src = e.target.result;
                    navPreview.classList.remove('hidden');
                }
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }

    // 2. Load Wilayah
    document.addEventListener('DOMContentLoaded', function () {
        const provinceSelect = document.getElementById('province_id');
        const citySelect = document.getElementById('city_id');
        const districtSelect = document.getElementById('district_id');
        const subDistrictSelect = document.getElementById('sub_district_id');
        const postalCodeInput = document.querySelector('input[name="postal_code"]');

        // Data Lama dari Database/Old Input
        const oldCity = "{{ old('city_id', $user->city_id) }}";
        const oldDistrict = "{{ old('district_id', $user->district_id) }}";
        const oldSubDistrict = "{{ old('sub_district_id', $user->sub_district_id) }}";

        function setLoading(select, text){
            if(!select) return;
            select.innerHTML = `<option value="" disabled selected>${text}</option>`;
        }

        function clearSelect(select, placeholder){
            if(!select) return;
            select.innerHTML = `<option value="" disabled selected>${placeholder}</option>`;
        }

        // --- LOAD CITIES ---
        function loadCities(provinceId){
            if(!citySelect || !provinceId) return;
            setLoading(citySelect, 'Memuat kota...');
            
            fetch(`/wilayah/cities?province_id=${provinceId}`)
                .then(r => r.json())
                .then(data => {
                    citySelect.innerHTML = '<option value="" disabled selected>Pilih Kota/Kabupaten</option>';
                    data.forEach(c => {
                        const opt = document.createElement('option');
                        opt.value = c.id;
                        opt.textContent = c.name;
                        if(oldCity && String(oldCity) === String(c.id)) opt.selected = true;
                        citySelect.appendChild(opt);
                    });
                    // Chain load district kalau kota sudah ada
                    if(oldCity && String(oldCity) !== "") loadDistricts(oldCity);
                });
        }

        // --- LOAD DISTRICTS ---
        function loadDistricts(cityId){
            if(!districtSelect || !cityId) return;
            setLoading(districtSelect, 'Memuat kecamatan...');
            fetch(`/wilayah/districts?city_id=${cityId}`)
                .then(r => r.json())
                .then(data => {
                    districtSelect.innerHTML = '<option value="" disabled selected>Pilih Kecamatan</option>';
                    data.forEach(d => {
                        const opt = document.createElement('option');
                        opt.value = d.id;
                        opt.textContent = d.name;
                        if(oldDistrict && String(oldDistrict) === String(d.id)) opt.selected = true;
                        districtSelect.appendChild(opt);
                    });
                    if(oldDistrict && String(oldDistrict) !== "") loadSubDistricts(oldDistrict);
                });
        }

        // --- LOAD SUB-DISTRICTS ---
        function loadSubDistricts(districtId){
            if(!subDistrictSelect || !districtId) return;
            setLoading(subDistrictSelect, 'Memuat kelurahan...');
            fetch(`/wilayah/subdistricts?district_id=${districtId}`)
                .then(r => r.json())
                .then(data => {
                    subDistrictSelect.innerHTML = '<option value="" disabled selected>Pilih Kelurahan</option>';
                    data.forEach(sd => {
                        const opt = document.createElement('option');
                        opt.value = sd.id;
                        opt.textContent = sd.name;
                        opt.dataset.postal = sd.postal_code; 
                        if(oldSubDistrict && String(oldSubDistrict) === String(sd.id)) opt.selected = true;
                        subDistrictSelect.appendChild(opt);
                    });
                });
        }

        // --- INIT: Cek jika sudah ada provinsi terpilih saat load (Edit Mode) ---
        if(provinceSelect && provinceSelect.value) {
            loadCities(provinceSelect.value);
        }

        // --- EVENT LISTENERS ---
        provinceSelect?.addEventListener('change', function(){ 
            clearSelect(citySelect, 'Pilih Kota'); clearSelect(districtSelect, 'Pilih Kecamatan'); clearSelect(subDistrictSelect, 'Pilih Kelurahan');
            if(postalCodeInput) postalCodeInput.value = '';
            loadCities(this.value); 
        });
        citySelect?.addEventListener('change', function(){ 
            clearSelect(districtSelect, 'Pilih Kecamatan'); clearSelect(subDistrictSelect, 'Pilih Kelurahan');
            if(postalCodeInput) postalCodeInput.value = '';
            loadDistricts(this.value); 
        });
        districtSelect?.addEventListener('change', function(){ 
            clearSelect(subDistrictSelect, 'Pilih Kelurahan');
            if(postalCodeInput) postalCodeInput.value = '';
            loadSubDistricts(this.value); 
        });
        subDistrictSelect?.addEventListener('change', function(){
            const selectedOption = this.options[this.selectedIndex];
            if(selectedOption && selectedOption.dataset.postal && postalCodeInput) postalCodeInput.value = selectedOption.dataset.postal;
        });
    });
</script>
@endsection