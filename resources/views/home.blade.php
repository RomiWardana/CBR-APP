<div class="hero-container">
    <div class="hero-content">
        <div class="brand-badge">Intelligence System</div>
        <h1>Solusi Cerdas<br><span class="gradient-text">Diagnosa Hardware</span></h1>
        
        <div class="description-section">
            <p>Mendeteksi kerusakan mesin dan perangkat keras secara menggunakan metode <strong>Case-Based Reasoning</strong>. Kami membantu Anda menemukan solusi berdasarkan histori kasus teknis yang terpercaya.</p>
            
            <div class="cbr-grid">
                <div class="cbr-item">
                    <div class="dot"></div>
                    <span>Retrieve & Reuse</span>
                </div>
                <div class="cbr-item">
                    <div class="dot"></div>
                    <span>Revise & Retain</span>
                </div>
            </div>
        </div>
        
        <div class="action-group">
            <a href="/login" class="btn-main">Masuk ke Akun</a>
            <a href="/register" class="btn-sub">Buat Akun Baru</a>
        </div>
    </div>
    
    <div class="hero-visual">
        <div class="glass-card">
            <div class="card-header">
                <div class="circle red"></div>
                <div class="circle yellow"></div>
                <div class="circle green"></div>
            </div>
            <div class="card-body">
                <div class="skeleton-line long"></div>
                <div class="skeleton-line medium"></div>
                <div class="skeleton-line short"></div>
                <div class="pulse-button">Processing Case...</div>
            </div>
        </div>
    </div>
</div>

<style>
    :root {
        --primary: #6366f1;
        --secondary: #4f46e5;
        --dark: #1e293b;
        --light-gray: #f8fafc;
        --text-muted: #64748b;
    }

    .hero-container {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 80px 5%;
        gap: 40px;
        min-height: 80vh;
        background: #ffffff;
    }

    .hero-content { flex: 1; }

    .brand-badge {
        display: inline-block;
        background: #eef2ff;
        color: var(--primary);
        padding: 8px 20px;
        border-radius: 100px;
        font-size: 13px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 24px;
    }

    .hero-content h1 {
        font-size: 4.5rem;
        font-weight: 800;
        line-height: 1;
        color: var(--dark);
        margin-bottom: 24px;
        letter-spacing: -2px;
    }

    .gradient-text {
        background: linear-gradient(90deg, var(--primary), #a855f7);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .description-section p {
        font-size: 1.15rem;
        color: var(--text-muted);
        line-height: 1.7;
        margin-bottom: 24px;
        max-width: 580px;
    }

    .cbr-grid {
        display: flex;
        gap: 20px;
        margin-bottom: 40px;
    }

    .cbr-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.95rem;
        color: var(--dark);
        font-weight: 500;
    }

    .dot {
        width: 8px;
        height: 8px;
        background: var(--primary);
        border-radius: 50%;
    }

    /* Button Styles */
    .action-group {
        display: flex;
        gap: 16px;
    }

    .btn-main {
        padding: 18px 36px;
        background: var(--dark);
        color: white;
        text-decoration: none;
        border-radius: 14px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-main:hover {
        background: #000;
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    }

    .btn-sub {
        padding: 18px 36px;
        background: transparent;
        color: var(--dark);
        text-decoration: none;
        border-radius: 14px;
        font-weight: 600;
        border: 2px solid #e2e8f0;
        transition: all 0.3s ease;
    }

    .btn-sub:hover {
        border-color: var(--dark);
        background: var(--light-gray);
    }

    /* Visual Element */
    .hero-visual {
        flex: 1;
        display: flex;
        justify-content: flex-end;
    }

    .glass-card {
        width: 380px;
        background: white;
        border-radius: 30px;
        padding: 24px;
        box-shadow: 0 50px 100px -20px rgba(50, 50, 93, 0.1), 0 30px 60px -30px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255,255,255,0.7);
        position: relative;
    }

    .card-header {
        display: flex;
        gap: 6px;
        margin-bottom: 30px;
    }

    .circle { width: 12px; height: 12px; border-radius: 50%; }
    .red { background: #ff5f56; }
    .yellow { background: #ffbd2e; }
    .green { background: #27c93f; }

    .skeleton-line {
        height: 12px;
        background: #f1f5f9;
        border-radius: 6px;
        margin-bottom: 16px;
    }
    .long { width: 100%; }
    .medium { width: 70%; }
    .short { width: 40%; }

    .pulse-button {
        margin-top: 40px;
        padding: 12px;
        background: #f8fafc;
        border: 1px dashed #cbd5e1;
        border-radius: 12px;
        color: var(--text-muted);
        font-size: 14px;
        text-align: center;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% { opacity: 1; }
        50% { opacity: 0.5; }
        100% { opacity: 1; }
    }

    @media (max-width: 1024px) {
        .hero-container { flex-direction: column; text-align: center; padding-top: 40px; }
        .hero-content h1 { font-size: 3rem; }
        .description-section p { margin: 0 auto 24px; }
        .cbr-grid, .action-group { justify-content: center; }
        .hero-visual { display: none; }
    }
</style>