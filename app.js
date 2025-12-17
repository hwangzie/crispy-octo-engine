// Certificate Management System
class CertificateManager {
    constructor() {
        this.certificates = this.loadCertificates();
        this.init();
    }

    init() {
        // Set today's date as default
        document.getElementById('issue-date').valueAsDate = new Date();

        // Event Listeners
        document.getElementById('certificate-form').addEventListener('submit', (e) => {
            e.preventDefault();
            this.createCertificate();
        });

        document.getElementById('search-input').addEventListener('input', (e) => {
            this.searchCertificates(e.target.value);
        });

        // Display certificates
        this.displayCertificates();
    }

    createCertificate() {
        const certificate = {
            id: this.generateId(),
            participantName: document.getElementById('participant-name').value,
            courseName: document.getElementById('course-name').value,
            instructorName: document.getElementById('instructor-name').value,
            issueDate: document.getElementById('issue-date').value,
            duration: document.getElementById('duration').value,
            description: document.getElementById('description').value,
            createdAt: new Date().toISOString()
        };

        this.certificates.push(certificate);
        this.saveCertificates();
        this.displayCertificates();

        // Show success message
        this.showNotification('Sertifikat berhasil dibuat!', 'success');

        // Reset form
        document.getElementById('certificate-form').reset();
        document.getElementById('issue-date').valueAsDate = new Date();

        // Switch to list tab
        showTab('list');
    }

    generateId() {
        return 'CERT-' + Date.now() + '-' + Math.random().toString(36).substr(2, 9).toUpperCase();
    }

    displayCertificates(certificatesToShow = this.certificates) {
        const listContainer = document.getElementById('certificates-list');

        if (certificatesToShow.length === 0) {
            listContainer.innerHTML = `
                <div class="empty-state">
                    <div class="empty-state-icon">📜</div>
                    <h3>Belum ada sertifikat</h3>
                    <p>Mulai dengan membuat sertifikat pertama Anda</p>
                </div>
            `;
            return;
        }

        // Sort by creation date (newest first)
        const sortedCertificates = [...certificatesToShow].sort((a, b) => 
            new Date(b.createdAt) - new Date(a.createdAt)
        );

        listContainer.innerHTML = sortedCertificates.map(cert => `
            <div class="certificate-item" data-id="${cert.id}">
                <div class="certificate-item-header">
                    <div class="certificate-item-info">
                        <h3>${cert.participantName}</h3>
                        <p>${cert.courseName}</p>
                    </div>
                    <div class="certificate-item-actions">
                        <button class="btn btn-primary" onclick="manager.viewCertificate('${cert.id}')">
                            Lihat
                        </button>
                        <button class="btn btn-danger" onclick="manager.deleteCertificate('${cert.id}')">
                            Hapus
                        </button>
                    </div>
                </div>
                <div class="certificate-details">
                    <div class="detail-item">
                        <strong>ID:</strong> ${cert.id}
                    </div>
                    <div class="detail-item">
                        <strong>Instruktur:</strong> ${cert.instructorName}
                    </div>
                    <div class="detail-item">
                        <strong>Tanggal:</strong> ${this.formatDate(cert.issueDate)}
                    </div>
                    <div class="detail-item">
                        <strong>Durasi:</strong> ${cert.duration} Jam
                    </div>
                </div>
            </div>
        `).join('');
    }

    viewCertificate(id) {
        const certificate = this.certificates.find(cert => cert.id === id);
        if (!certificate) return;

        const modal = document.getElementById('certificate-modal');
        const preview = document.getElementById('certificate-preview');

        preview.innerHTML = `
            <div class="certificate-header">
                <div class="certificate-title">Sertifikat</div>
                <div class="certificate-subtitle">Certificate of Completion</div>
            </div>
            <div class="certificate-body">
                <div class="certificate-presented-to">Sertifikat ini diberikan kepada</div>
                <div class="certificate-recipient">${certificate.participantName}</div>
                <div class="certificate-course">
                    Telah menyelesaikan pelatihan<br>
                    <strong>${certificate.courseName}</strong>
                </div>
                ${certificate.description ? `
                    <div class="certificate-description">${certificate.description}</div>
                ` : ''}
                <div class="certificate-details">
                    <div class="detail-item">
                        <strong>Durasi Pelatihan:</strong> ${certificate.duration} Jam
                    </div>
                    <div class="detail-item">
                        <strong>Tanggal Penerbitan:</strong> ${this.formatDate(certificate.issueDate)}
                    </div>
                </div>
            </div>
            <div class="certificate-footer">
                <div class="certificate-signature">
                    <div class="signature-line"></div>
                    <div class="signature-name">${certificate.instructorName}</div>
                    <div class="signature-title">Instruktur</div>
                </div>
                <div class="certificate-signature">
                    <div class="signature-line"></div>
                    <div class="signature-name">Direktur</div>
                    <div class="signature-title">Lembaga Pelatihan</div>
                </div>
            </div>
            <div class="certificate-id">ID: ${certificate.id}</div>
        `;

        modal.style.display = 'block';
        
        // Store current certificate ID for printing
        modal.dataset.certificateId = id;
    }

    deleteCertificate(id) {
        if (!confirm('Apakah Anda yakin ingin menghapus sertifikat ini?')) {
            return;
        }

        this.certificates = this.certificates.filter(cert => cert.id !== id);
        this.saveCertificates();
        this.displayCertificates();
        this.showNotification('Sertifikat berhasil dihapus', 'success');
    }

    searchCertificates(query) {
        if (!query.trim()) {
            this.displayCertificates();
            return;
        }

        const lowerQuery = query.toLowerCase();
        const filtered = this.certificates.filter(cert => 
            cert.participantName.toLowerCase().includes(lowerQuery) ||
            cert.courseName.toLowerCase().includes(lowerQuery) ||
            cert.instructorName.toLowerCase().includes(lowerQuery) ||
            cert.id.toLowerCase().includes(lowerQuery)
        );

        this.displayCertificates(filtered);
    }

    formatDate(dateString) {
        const options = { year: 'numeric', month: 'long', day: 'numeric' };
        return new Date(dateString).toLocaleDateString('id-ID', options);
    }

    saveCertificates() {
        localStorage.setItem('certificates', JSON.stringify(this.certificates));
    }

    loadCertificates() {
        const stored = localStorage.getItem('certificates');
        return stored ? JSON.parse(stored) : [];
    }

    showNotification(message, type = 'info') {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.textContent = message;
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: ${type === 'success' ? '#50c878' : '#4a90e2'};
            color: white;
            padding: 15px 25px;
            border-radius: 6px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            z-index: 10000;
            animation: slideIn 0.3s ease;
        `;

        document.body.appendChild(notification);

        // Remove after 3 seconds
        setTimeout(() => {
            notification.style.animation = 'slideOut 0.3s ease';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }
}

// Tab switching function
function showTab(tabName) {
    // Hide all tabs
    document.querySelectorAll('.tab-content').forEach(tab => {
        tab.classList.remove('active');
    });

    // Remove active class from all buttons
    document.querySelectorAll('.tab-button').forEach(button => {
        button.classList.remove('active');
    });

    // Show selected tab
    document.getElementById(`${tabName}-tab`).classList.add('active');

    // Add active class to clicked button
    event.target.classList.add('active');
}

// Modal functions
function closeModal() {
    document.getElementById('certificate-modal').style.display = 'none';
}

function printCertificate() {
    window.print();
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById('certificate-modal');
    if (event.target === modal) {
        closeModal();
    }
}

// Add CSS animations
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);

// Initialize the application
let manager;
document.addEventListener('DOMContentLoaded', () => {
    manager = new CertificateManager();
});
