/* File: public/js/kalori.js (Versi BARU - Modal + Gram Input) */

document.addEventListener('DOMContentLoaded', () => {
    
    // Ambil data PHP
    // 'foods' sekarang tidak dipakai lagi, kita akan ambil dari API
    const { userTargets, apiUrls } = APP_DATA;
    let selectedFood = null;
    let searchTimeout = null;

    // Elemen UI Utama
    const elements = {
        dateSelector: document.getElementById('dateSelector'),
        
        // Ringkasan
        totalCalories: document.getElementById('totalCalories'),
        targetCalories: document.getElementById('targetCalories'),
        caloriesPercentage: document.getElementById('caloriesPercentage'),
        proteinGram: document.getElementById('proteinGram'),
        carbsGram: document.getElementById('carbsGram'),
        fatsGram: document.getElementById('fatsGram'),
        caloriesProgress: document.getElementById('caloriesProgress'),
        proteinBar: document.getElementById('proteinBar'),
        carbsBar: document.getElementById('carbsBar'),
        fatsBar: document.getElementById('fatsBar'),
        bannerCalories: document.getElementById('bannerCalories'),
        bannerItems: document.getElementById('bannerItems'),
        
        // Search
        searchInput: document.getElementById('searchFood'),
        clearSearchBtn: document.getElementById('clearSearch'),
        filterButtons: document.querySelectorAll('.filter-btn'),
        foodResultsGrid: document.getElementById('foodResults'),
        emptyState: document.getElementById('emptyState'),
        
        // Modal (DIUBAH)
        modal: document.getElementById('addFoodModal'),
        modalForm: document.getElementById('addFoodForm'),
        closeModalBtn: document.getElementById('closeAddModalBtn'),
        cancelModalBtn: document.getElementById('cancelAddModalBtn'),
        modalFoodImage: document.getElementById('modalFoodImage'),
        modalFoodName: document.getElementById('modalFoodName'),
        modalFoodPortion: document.getElementById('modalFoodPortion'),
        inputGrams: document.getElementById('inputGrams'), // Input baru
        previewCalories: document.getElementById('previewCalories'),
        previewProtein: document.getElementById('previewProtein'),
        previewCarbs: document.getElementById('previewCarbs'),
        previewFats: document.getElementById('previewFats'),
        
        // Notifikasi
        toast: document.getElementById('toast'),
        loadingOverlay: document.getElementById('loadingOverlay'),
    };
    
    // =================================================================
    // FUNGSI UTAMA (API & RENDER)
    // =================================================================

    /**
     * Memuat ringkasan total (lingkaran & bar) dari server
     */
    async function loadIntakeSummary() {
        const selectedDate = elements.dateSelector.value;
        showLoading(true);

        try {
            const response = await fetch(`${apiUrls.getIntake}&date=${selectedDate}`);
            if (!response.ok) throw new Error('Network response error');
            
            const result = await response.json();
            
            if (result.success && result.data) {
                updateSummary(result.data); // Panggil fungsi update UI
            } else {
                updateSummary([]); // Kirim array kosong jika tidak ada data
            }
        } catch (error) {
            console.error('Gagal memuat data intake:', error);
            showToast('Gagal memuat ringkasan', 'error');
        } finally {
            showLoading(false);
        }
    }

    /**
     * FUNGSI UTAMA: Memperbarui UI ringkasan (lingkaran & bar)
     */
    function updateSummary(intakeItems) {
        const totals = { calories: 0, protein: 0, carbs: 0, fats: 0 };
        
        intakeItems.forEach(item => {
            const portion = parseFloat(item.portion_multiplier) || 1;
            totals.calories += (parseFloat(item.calories) || 0) * portion;
            totals.protein += (parseFloat(item.protein) || 0) * portion;
            totals.carbs += (parseFloat(item.carbs) || 0) * portion;
            totals.fats += (parseFloat(item.fats) || 0) * portion;
        });

        const percentages = {
            calories: (totals.calories / userTargets.calories) * 100,
            protein: (totals.protein / userTargets.protein) * 100,
            carbs: (totals.carbs / userTargets.carbs) * 100,
            fats: (totals.fats / userTargets.fats) * 100,
        };

        // Update teks
        elements.totalCalories.textContent = Math.round(totals.calories);
        elements.caloriesPercentage.textContent = `${Math.round(percentages.calories)}%`;
        elements.proteinGram.textContent = Math.round(totals.protein);
        elements.carbsGram.textContent = Math.round(totals.carbs);
        elements.fatsGram.textContent = Math.round(totals.fats);
        elements.bannerCalories.textContent = Math.round(totals.calories);
        elements.bannerItems.textContent = intakeItems.length;

        // Update Lingkaran SVG
        const circumference = 754; // Diambil dari stroke-dasharray di HTML Anda
        const offset = circumference - (Math.min(percentages.calories, 100) / 100) * circumference;
        elements.caloriesProgress.style.strokeDashoffset = offset;

        // Update Progress Bar Makro
        elements.proteinBar.style.width = `${Math.min(percentages.protein, 100)}%`;
        elements.carbsBar.style.width = `${Math.min(percentages.carbs, 100)}%`;
        elements.fatsBar.style.width = `${Math.min(percentages.fats, 100)}%`;
    }

    /**
     * (DIUBAH) Mencari makanan (dipanggil saat mengetik)
     */
    async function searchFoods() {
        const keyword = elements.searchInput.value.trim();
        const activeFilter = document.querySelector('.filter-btn.active');
        const category = activeFilter ? activeFilter.dataset.category : 'all';
        
        // Tampilkan spinner HANYA jika keyword TIDAK KOSONG
        if(keyword) {
            showFoodGridLoading(true);
            elements.emptyState.style.display = 'none';
        } else {
            // Jika keyword kosong, bersihkan grid dan jangan tampilkan apa-apa
            elements.foodResultsGrid.innerHTML = '';
            elements.emptyState.style.display = 'none';
            return; // Berhenti di sini
        }

        try {
            // Panggil API search (dari data dummy)
            const response = await fetch(`${apiUrls.search}&keyword=${keyword}&category=${category}`);
            const result = await response.json();
            
            if (result.success && result.data) {
                renderFoodResults(result.data);
            } else {
                renderFoodResults([]); // Tampilkan kosong
            }
        } catch (error) {
            console.error('Gagal mencari makanan:', error);
            showToast('Gagal mencari makanan', 'error');
            renderFoodResults([]);
        } finally {
            showFoodGridLoading(false);
        }
    }

    /**
     * (DIUBAH) Menggambar hasil pencarian (kartu oatmeal)
     */
    function renderFoodResults(foods) {
        elements.foodResultsGrid.innerHTML = ''; // Kosongkan grid

        if (foods.length === 0 && elements.searchInput.value.trim()) {
            elements.emptyState.style.display = 'block';
            return;
        }

        elements.emptyState.style.display = 'none';
        
        foods.forEach(food => {
            const item = document.createElement('div');
            item.className = 'food-item';
            // Simpan data lengkap di elemen untuk dipakai nanti
            item.dataset.food = JSON.stringify(food); 
            
            // Hitung kalori per 100g untuk ditampilkan
            const calPer100g = Math.round((food.calories / food.base_grams) * 100);

            item.innerHTML = `
                <img src="${food.image || '/SiSehat/public/images/default-plate.jpg'}" alt="${food.name}" class="food-item-img" onerror="this.src='/SiSehat/public/images/default-plate.jpg'">
                <div class="food-item-content">
                    <div class="food-item-name">${food.name}</div>
                    <div class="food-item-nutrition">${calPer100g} kkal / 100g</div>
                </div>
            `;
            
            // Event listener tetap membuka MODAL
            item.addEventListener('click', () => {
                selectedFood = food; // Simpan data makanan yang diklik
                openAddModal(food);
            });
            
            elements.foodResultsGrid.appendChild(item);
        });
    }

    /**
     * (DIUBAH) Menangani pengiriman form (menghitung porsi dari gram)
     */
    async function handleAddFoodSubmit(event) {
        event.preventDefault();
        
        if (!selectedFood) {
             showToast('Makanan tidak valid', 'error');
             return;
        }

        const inputGrams = parseFloat(elements.inputGrams.value);
        if (isNaN(inputGrams) || inputGrams <= 0) {
            showToast('Masukkan jumlah gram yang valid', 'error');
            return;
        }

        // LOGIKA KUNCI: Hitung 'portion_multiplier' dari 'gram'
        const portionMultiplier = inputGrams / selectedFood.base_grams;

        showLoading(true);

        const formData = new FormData(elements.modalForm);
        // Hapus input gram palsu (karena API tidak butuh)
        formData.delete('input_grams'); 
        // Tambahkan data yang benar
        formData.append('food_id', selectedFood.id);
        formData.append('portion_multiplier', portionMultiplier);
        formData.append('intake_date', elements.dateSelector.value); 

        try {
            const response = await fetch(apiUrls.add, {
                method: 'POST',
                body: formData
            });
            const result = await response.json();

            if (result.success) {
                showToast('Makanan berhasil ditambahkan!');
                closeAddModal();
                loadIntakeSummary(); // Muat ulang ringkasan
            } else {
                showToast(result.message || 'Gagal menambahkan makanan', 'error');
            }
        } catch (error) {
            console.error('Error saat menambah makanan:', error);
            showToast('Terjadi kesalahan', 'error');
        } finally {
            showLoading(false);
        }
    }

    // =================================================================
    // FUNGSI MODAL (DIUBAH)
    // =================================================================

    function openAddModal(food) {
        elements.modalFoodImage.src = food.image || '/SiSehat/public/images/default-plate.jpg';
        elements.modalFoodName.textContent = food.name;
        // Tampilkan info porsi dasarnya
        elements.modalFoodPortion.textContent = `${food.description} (${Math.round(food.base_grams)}g)`;
        // Set input gram ke nilai default
        elements.inputGrams.value = food.base_grams; 
        
        updatePreviewNutrition(); // Update preview nutrisi di modal
        elements.modal.classList.add('show');
    }

    function closeAddModal() {
        elements.modal.classList.remove('show');
        selectedFood = null; // Hapus data makanan
        elements.modalForm.reset(); // Reset form
    }

    /**
     * (DIUBAH) Menghitung preview nutrisi berdasarkan GRAM
     */
    function updatePreviewNutrition() {
        if (!selectedFood) return;
        
        const inputGrams = parseFloat(elements.inputGrams.value) || 0;
        // Hitung porsi saat ini
        const portion = inputGrams / selectedFood.base_grams; 
        
        elements.previewCalories.textContent = `${Math.round(selectedFood.calories * portion)} kkal`;
        elements.previewProtein.textContent = `${(selectedFood.protein * portion).toFixed(1)}g`;
        elements.previewCarbs.textContent = `${(selectedFood.carbs * portion).toFixed(1)}g`;
        elements.previewFats.textContent = `${(selectedFood.fats * portion).toFixed(1)}g`;
    }
    

    // =================================================================
    // FUNGSI HELPER (Toast, Loading)
    // =================================================================

    function showToast(message, type = 'success') {
        elements.toast.textContent = message;
        elements.toast.className = `toast show ${type}`;
        setTimeout(() => {
            elements.toast.className = elements.toast.className.replace('show', '');
        }, 3000);
    }

    function showLoading(isLoading) {
        elements.loadingOverlay.classList.toggle('show', isLoading);
    }
    
    function showFoodGridLoading(isLoading) {
        const spinner = elements.foodResultsGrid.querySelector('.loading-spinner');
        if (isLoading) {
            if (!spinner) {
                elements.foodResultsGrid.innerHTML = `<div class="loading-spinner"><div class="spinner"></div><p>Memuat makanan...</p></div>`;
            }
        } else {
            if (spinner) {
                elements.foodResultsGrid.innerHTML = '';
            }
        }
    }

    // =================================================================
    // INISIALISASI & EVENT LISTENERS
    // =================================================================

    // --- Search & Filter (DIUBAH JADI 'keyup') ---
    elements.searchInput.addEventListener('keyup', () => {
        clearTimeout(searchTimeout); 
        elements.clearSearchBtn.style.display = elements.searchInput.value ? 'block' : 'none';
        // Panggil API 300ms setelah user berhenti mengetik (Google Style)
        searchTimeout = setTimeout(searchFoods, 300); 
    });

    elements.clearSearchBtn.addEventListener('click', () => {
        elements.searchInput.value = '';
        elements.clearSearchBtn.style.display = 'none';
        searchFoods(); // Ini akan membersihkan grid
    });

    elements.filterButtons.forEach(button => {
        button.addEventListener('click', () => {
            elements.filterButtons.forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');
            searchFoods(); // Langsung cari (jika ada keyword)
        });
    });

    // --- Modal ---
    elements.modalForm.addEventListener('submit', handleAddFoodSubmit);
    elements.closeModalBtn.addEventListener('click', closeAddModal);
    elements.cancelModalBtn.addEventListener('click', closeAddModal);
    // (DIUBAH) Update preview saat mengetik gram
    elements.inputGrams.addEventListener('input', updatePreviewNutrition); 

    // --- Lainnya ---
    elements.dateSelector.addEventListener('change', loadIntakeSummary);

    // --- PANGGILAN PERTAMA SAAT HALAMAN DIMUAT ---
    loadIntakeSummary(); // Muat ringkasan hari ini
    // Kita TIDAK panggil searchFoods() lagi, biarkan kosong sampai user mengetik
});