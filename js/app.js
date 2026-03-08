/**
 * University Procurement Portal
 * Main JavaScript Application
 * Reusable functions for all pages
 */

// Global State
const AppState = {
    items: typeof itemsData !== 'undefined' ? itemsData : [],
    userRole: typeof userRole !== 'undefined' ? userRole : 'user',
    currentItem: null
};

// DOM Elements
const Elements = {
    menuToggle: document.getElementById('menuToggle'),
    sidebar: document.getElementById('sidebar'),
    navItems: document.querySelectorAll('.nav-item'),
    viewModal: document.getElementById('viewModal'),
    uploadModal: document.getElementById('uploadModal'),
    closeModal: document.getElementById('closeModal'),
    closeModalBtn: document.getElementById('closeModalBtn'),
    uploadBtn: document.getElementById('uploadBtn'),
    closeUploadModal: document.getElementById('closeUploadModal'),
    cancelUpload: document.getElementById('cancelUpload'),
    uploadForm: document.getElementById('uploadForm'),
    searchInput: document.getElementById('searchInput'),
    copySpecsBtn: document.getElementById('copySpecsBtn'),
    toast: document.getElementById('toast'),
    toastMessage: document.getElementById('toastMessage'),
    modalTitle: document.getElementById('modalTitle'),
    modalCategory: document.getElementById('modalCategory'),
    modalDate: document.getElementById('modalDate'),
    modalSpecs: document.getElementById('modalSpecs')
};

/**
 * Initialize the application
 */
function initApp() {
    setupEventListeners();
    setupViewButtons();
    setupCopyButtons();
    setupDeleteButtons();
    setupEditButtons();
}

/**
 * Setup all event listeners
 */
function setupEventListeners() {
    // Mobile menu toggle
    if (Elements.menuToggle) {
        Elements.menuToggle.addEventListener('click', toggleSidebar);
    }

    // Close sidebar on mobile when clicking outside
    document.addEventListener('click', (e) => {
        if (window.innerWidth <= 768) {
            if (!Elements.sidebar?.contains(e.target) && !Elements.menuToggle?.contains(e.target)) {
                closeSidebar();
            }
        }
    });

    // Navigation items
    Elements.navItems.forEach(item => {
        item.addEventListener('click', (e) => {
            e.preventDefault();
            handleNavigation(item);
        });
    });

    // Modal close buttons
    Elements.closeModal?.addEventListener('click', () => closeModal(Elements.viewModal));
    Elements.closeModalBtn?.addEventListener('click', () => closeModal(Elements.viewModal));
    Elements.closeUploadModal?.addEventListener('click', () => closeModal(Elements.uploadModal));
    Elements.cancelUpload?.addEventListener('click', () => closeModal(Elements.uploadModal));

    // Close modal on backdrop click
    document.querySelectorAll('.modal-backdrop').forEach(backdrop => {
        backdrop.addEventListener('click', () => {
            const modal = backdrop.closest('.modal');
            closeModal(modal);
        });
    });

    // Upload button
    Elements.uploadBtn?.addEventListener('click', () => openModal(Elements.uploadModal));

    // Upload form submission
    Elements.uploadForm?.addEventListener('submit', handleUpload);

    // Search functionality
    Elements.searchInput?.addEventListener('input', handleSearch);

    // Copy specs button
    Elements.copySpecsBtn?.addEventListener('click', copySpecsToClipboard);

    // Keyboard navigation
    document.addEventListener('keydown', handleKeyboard);
}

/**
 * Toggle sidebar on mobile
 */
function toggleSidebar() {
    Elements.sidebar?.classList.toggle('active');
}

/**
 * Close sidebar
 */
function closeSidebar() {
    Elements.sidebar?.classList.remove('active');
}

/**
 * Handle navigation
 */
function handleNavigation(navItem) {
    // Remove active class from all nav items
    Elements.navItems.forEach(item => item.classList.remove('active'));
    // Add active class to clicked item
    navItem.classList.add('active');

    // Close sidebar on mobile
    closeSidebar();

    // Update page title
    const pageName = navItem.querySelector('span')?.textContent || 'Dashboard';
    const pageTitle = document.getElementById('pageTitle');
    if (pageTitle) {
        pageTitle.textContent = pageName;
    }

    // Handle different pages (can be expanded)
    const page = navItem.dataset.page;
    switch (page) {
        case 'upload':
            openModal(Elements.uploadModal);
            break;
        case 'browse':
            Elements.searchInput?.focus();
            break;
    }
}

/**
 * Setup view buttons
 */
function setupViewButtons() {
    document.querySelectorAll('.btn-view').forEach(btn => {
        btn.addEventListener('click', () => {
            const itemId = parseInt(btn.dataset.id);
            viewItem(itemId);
        });
    });
}

/**
 * Setup copy buttons
 */
function setupCopyButtons() {
    document.querySelectorAll('.btn-copy').forEach(btn => {
        btn.addEventListener('click', () => {
            const itemId = parseInt(btn.dataset.id);
            copyItemSpecs(itemId);
        });
    });
}

/**
 * Setup delete buttons
 */
function setupDeleteButtons() {
    document.querySelectorAll('.btn-delete').forEach(btn => {
        btn.addEventListener('click', () => {
            const itemId = parseInt(btn.dataset.id);
            deleteItem(itemId);
        });
    });
}

/**
 * Setup edit buttons
 */
function setupEditButtons() {
    document.querySelectorAll('.btn-edit').forEach(btn => {
        btn.addEventListener('click', () => {
            const itemId = parseInt(btn.dataset.id);
            editItem(itemId);
        });
    });
}

/**
 * Open modal
 */
function openModal(modal) {
    modal?.classList.add('active');
    document.body.style.overflow = 'hidden';
}

/**
 * Close modal
 */
function closeModal(modal) {
    modal?.classList.remove('active');
    document.body.style.overflow = '';
}

/**
 * View item details
 */
function viewItem(itemId) {
    const item = AppState.items.find(i => i.id === itemId);
    if (!item) return;

    AppState.currentItem = item;

    if (Elements.modalTitle) Elements.modalTitle.textContent = item.name;
    if (Elements.modalCategory) Elements.modalCategory.textContent = item.category;
    if (Elements.modalDate) Elements.modalDate.textContent = item.date;
    if (Elements.modalSpecs) Elements.modalSpecs.textContent = item.specs;

    openModal(Elements.viewModal);
}

/**
 * Copy item specs to clipboard
 */
function copyItemSpecs(itemId) {
    const item = AppState.items.find(i => i.id === itemId);
    if (!item) return;

    const textToCopy = `${item.name}\nCategory: ${item.category}\n\nTechnical Specifications:\n${item.specs}`;

    navigator.clipboard.writeText(textToCopy).then(() => {
        showToast('Specifications copied to clipboard!');
    }).catch(() => {
        showToast('Failed to copy specifications', 'error');
    });
}

/**
 * Copy specs from modal
 */
function copySpecsToClipboard() {
    if (!AppState.currentItem) return;

    const item = AppState.currentItem;
    const textToCopy = `${item.name}\nCategory: ${item.category}\n\nTechnical Specifications:\n${item.specs}`;

    navigator.clipboard.writeText(textToCopy).then(() => {
        showToast('Specifications copied to clipboard!');
        closeModal(Elements.viewModal);
    }).catch(() => {
        showToast('Failed to copy specifications', 'error');
    });
}

/**
 * Delete item
 */
function deleteItem(itemId) {
    if (!confirm('Are you sure you want to delete this item?')) return;

    AppState.items = AppState.items.filter(i => i.id !== itemId);

    // Remove row from table
    const row = document.querySelector(`tr[data-id="${itemId}"]`);
    if (row) {
        row.style.opacity = '0';
        setTimeout(() => row.remove(), 200);
    }

    showToast('Item deleted successfully!');
}

/**
 * Edit item
 */
function editItem(itemId) {
    const item = AppState.items.find(i => i.id === itemId);
    if (!item) return;

    // Populate form with item data
    const nameInput = document.getElementById('itemName');
    const categorySelect = document.getElementById('itemCategory');
    const specsTextarea = document.getElementById('itemSpecs');

    if (nameInput) nameInput.value = item.name;
    if (categorySelect) categorySelect.value = item.category;
    if (specsTextarea) specsTextarea.value = item.specs;

    // Change form to edit mode (can be expanded)
    openModal(Elements.uploadModal);
}

/**
 * Handle upload form submission
 */
function handleUpload(e) {
    e.preventDefault();

    const formData = new FormData(Elements.uploadForm);
    const itemName = formData.get('itemName');
    const itemCategory = formData.get('itemCategory');
    const itemSpecs = formData.get('itemSpecs');

    if (!itemName || !itemCategory || !itemSpecs) {
        showToast('Please fill in all required fields', 'error');
        return;
    }

    // Create new item (in production, send to server)
    const newItem = {
        id: AppState.items.length + 1,
        name: itemName,
        category: itemCategory,
        specs: itemSpecs,
        uploaded_by: 'TWG',
        date: new Date().toISOString().split('T')[0]
    };

    AppState.items.push(newItem);

    // Add new row to table
    addTableRow(newItem);

    // Reset form and close modal
    Elements.uploadForm?.reset();
    closeModal(Elements.uploadModal);

    showToast('Item uploaded successfully!');
}

/**
 * Add new row to table
 */
function addTableRow(item) {
    const tbody = document.querySelector('.table tbody');
    if (!tbody) return;

    const row = document.createElement('tr');
    row.dataset.id = item.id;
    row.innerHTML = `
        <td>#${item.id}</td>
        <td>
            <div class="item-name">
                <i class="fas fa-box-open"></i>
                ${escapeHtml(item.name)}
            </div>
        </td>
        <td><span class="badge badge-neutral">${escapeHtml(item.category)}</span></td>
        <td>${escapeHtml(item.uploaded_by)}</td>
        <td>${escapeHtml(item.date)}</td>
        <td>
            <button class="btn-icon btn-view" data-id="${item.id}" title="View Specs">
                <i class="fas fa-eye"></i>
            </button>
            ${AppState.userRole === 'user' ? `
            <button class="btn-icon btn-copy" data-id="${item.id}" title="Copy Specs">
                <i class="fas fa-copy"></i>
            </button>
            ` : ''}
            ${AppState.userRole === 'twg' ? `
            <button class="btn-icon btn-edit" data-id="${item.id}" title="Edit">
                <i class="fas fa-edit"></i>
            </button>
            <button class="btn-icon btn-delete" data-id="${item.id}" title="Delete">
                <i class="fas fa-trash"></i>
            </button>
            ` : ''}
        </td>
    `;

    tbody.appendChild(row);

    // Setup event listeners for new buttons
    const viewBtn = row.querySelector('.btn-view');
    const copyBtn = row.querySelector('.btn-copy');
    const editBtn = row.querySelector('.btn-edit');
    const deleteBtn = row.querySelector('.btn-delete');

    if (viewBtn) viewBtn.addEventListener('click', () => viewItem(item.id));
    if (copyBtn) copyBtn.addEventListener('click', () => copyItemSpecs(item.id));
    if (editBtn) editBtn.addEventListener('click', () => editItem(item.id));
    if (deleteBtn) deleteBtn.addEventListener('click', () => deleteItem(item.id));

    // Add animation
    row.style.opacity = '0';
    setTimeout(() => {
        row.style.opacity = '1';
    }, 10);
}

/**
 * Handle search
 */
function handleSearch(e) {
    const searchTerm = e.target.value.toLowerCase();
    const rows = document.querySelectorAll('.table tbody tr');

    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchTerm) ? '' : 'none';
    });
}

/**
 * Handle keyboard navigation
 */
function handleKeyboard(e) {
    // Close modal on Escape
    if (e.key === 'Escape') {
        const activeModal = document.querySelector('.modal.active');
        if (activeModal) {
            closeModal(activeModal);
        }
    }
}

/**
 * Show toast notification
 */
function showToast(message, type = 'success') {
    if (!Elements.toast || !Elements.toastMessage) return;

    Elements.toastMessage.textContent = message;

    // Update toast color based on type
    Elements.toast.style.borderLeftColor = type === 'error' ? '#ef4444' : '#10b981';
    const icon = Elements.toast.querySelector('i');
    if (icon) {
        icon.className = type === 'error' ? 'fas fa-exclamation-circle' : 'fas fa-check-circle';
        icon.style.color = type === 'error' ? '#ef4444' : '#10b981';
    }

    Elements.toast.classList.add('show');

    setTimeout(() => {
        Elements.toast.classList.remove('show');
    }, 3000);
}

/**
 * Escape HTML to prevent XSS
 */
function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

/**
 * Format date
 */
function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    });
}

/**
 * Format number with commas
 */
function formatNumber(num) {
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
}

/**
 * Debounce function
 */
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

/**
 * Initialize app when DOM is ready
 */
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initApp);
} else {
    initApp();
}

// Export functions for use in other files
window.ProcurementApp = {
    initApp,
    openModal,
    closeModal,
    showToast,
    formatDate,
    formatNumber,
    escapeHtml,
    debounce
};