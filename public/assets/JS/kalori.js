document.addEventListener('DOMContentLoaded', () => {
    
    const { apiUrls } = APP_DATA;
    let searchTimeout = null;

    const elements = {
        dateSelector: document.getElementById('dateSelector'),
        searchInput: document.getElementById('searchFood'),
        clearSearchBtn: document.getElementById('clearSearch'),
        filterButtons: document.querySelectorAll('.filter-btn'),
        foodResultsGrid: document.getElementById('foodResults'),
        emptyState: document.getElementById('emptyState'),
        intakeListWrapper: document.getElementById('todaysIntakeList'),
        summaryWrapper: document.querySelector('.nutrition-summary'),
        bannerWrapper: document.querySelector('.kalori-banner'),
        toast: document.getElementById('toast'),
        loadingOverlay: document.getElementById('loadingOverlay'),
    };

    function showLoading(isLoading) {
        elements.loadingOverlay.style.display = isLoading ? 'flex' : 'none';
    }

    function showToast(message, type = 'success') {
        elements.toast.textContent = message;
        elements.toast.className = `toast show ${type}`;
        setTimeout(() => {
            elements.toast.className = elements.toast.className.replace('show', '');
        }, 3000);
    }

    async function refreshPageData() {
        showLoading(true);
        try {
            const date = elements.dateSelector.value;
            const response = await fetch(`index.php?action=kalori&date=${date}`);
            const html = await response.text();
            
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            
            const newIntake = doc.getElementById('todaysIntakeList').innerHTML;
            const newSummary = doc.querySelector('.nutrition-summary').innerHTML;
            const newBanner = doc.querySelector('.kalori-banner').innerHTML;
            
            elements.intakeListWrapper.innerHTML = newIntake;
            elements.summaryWrapper.innerHTML = newSummary;
            elements.bannerWrapper.innerHTML = newBanner;
            
        } catch (error) {
            console.error('Gagal refresh data:', error);
            showToast('Gagal memuat ulang data', 'error');
        } finally {
            showLoading(false);
        }
    }

    async function searchFoods() {
        const keyword = elements.searchInput.value.trim();
        const activeFilter = document.querySelector('.filter-btn.active');
        const category = activeFilter ? activeFilter.dataset.category : 'all';
        const date = elements.dateSelector.value;

        if (!keyword) {
            elements.foodResultsGrid.innerHTML = '';
            elements.emptyState.style.display = 'none';
            return;
        }

        try {
            const response = await fetch(`${apiUrls.search}&keyword=${keyword}&category=${category}&date=${date}`);
            const result = await response.json();
            
            if (result.success) {
                elements.foodResultsGrid.innerHTML = result.html;
                elements.emptyState.style.display = result.html.trim() === '' ? 'block' : 'none';
            }
        } catch (error) {
            console.error('Gagal mencari makanan:', error);
        }
    }

    async function handleAddIntake(event) {
        event.preventDefault();
        showLoading(true);
        
        const form = event.currentTarget;
        const formData = new FormData(form);
        formData.append('intake_date', elements.dateSelector.value);
        
        try {
            const response = await fetch(apiUrls.add, {
                method: 'POST',
                body: formData
            });
            const result = await response.json();
            
            if (result.success) {
                showToast('Makanan berhasil ditambahkan!');
                elements.searchInput.value = '';
                elements.foodResultsGrid.innerHTML = '';
                await refreshPageData();
            } else {
                showToast(result.message || 'Gagal menambahkan', 'error');
            }
        } catch (error) {
            console.error('Gagal menambah:', error);
        } finally {
            showLoading(false);
        }
    }
    
    async function handleDeleteIntake(event) {
        event.preventDefault();
        if (!confirm('Yakin ingin menghapus item ini?')) {
            return;
        }
        
        showLoading(true);
        const form = event.currentTarget;
        const formData = new FormData(form);
        formData.append('intake_date', elements.dateSelector.value);

        try {
            const response = await fetch(apiUrls.delete, {
                method: 'POST',
                body: formData
            });
            const result = await response.json();
            
            if (result.success) {
                showToast('Makanan berhasil dihapus!');
                await refreshPageData();
            } else {
                showToast('Gagal menghapus', 'error');
            }
        } catch (error) {
            console.error('Gagal menghapus:', error);
        } finally {
            showLoading(false);
        }
    }

    function handleEditClick(event) {
        event.preventDefault();
        const button = event.currentTarget;
        const intakeId = button.dataset.id;
        const date = elements.dateSelector.value;
        
        window.location.href = `index.php?action=kalori&date=${date}&edit_id=${intakeId}`;
    }

    elements.searchInput.addEventListener('keyup', () => {
        clearTimeout(searchTimeout);
        elements.clearSearchBtn.style.display = elements.searchInput.value ? 'block' : 'none';
        searchTimeout = setTimeout(searchFoods, 300);
    });

    elements.clearSearchBtn.addEventListener('click', () => {
        elements.searchInput.value = '';
        elements.clearSearchBtn.style.display = 'none';
        searchFoods();
    });

    elements.filterButtons.forEach(button => {
        button.addEventListener('click', (e) => {
            e.preventDefault();
            elements.filterButtons.forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');
            searchFoods();
        });
    });

    elements.dateSelector.addEventListener('change', () => {
        window.location.href = `index.php?action=kalori&date=${elements.dateSelector.value}`;
    });

    document.body.addEventListener('submit', function(event) {
        if (event.target.classList.contains('form-add-intake')) {
            handleAddIntake(event);
        }
        if (event.target.classList.contains('form-delete-intake')) {
            handleDeleteIntake(event);
        }
    });
    
    document.body.addEventListener('click', function(event) {
        if (event.target.classList.contains('btn-edit')) {
            handleEditClick(event);
        }
    });

});