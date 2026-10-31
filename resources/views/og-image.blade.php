<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OG Image</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;700;800;900&display=swap');

        body {
            width: 1200px;
            height: 630px;
            overflow: hidden;
            background: #f0f4f8;
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            display: flex;
            align-items: stretch;
        }

        /* Left dark panel */
        .left {
            width: 380px;
            background: #0f172a;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 52px 44px;
        }

        .logo-mark {
            width: 64px;
            height: 64px;
        }

        .brand-name {
            font-size: 22px;
            font-weight: 800;
            color: #ffffff;
            letter-spacing: -0.04em;
            margin-top: 6px;
        }

        .domain {
            font-size: 11px;
            font-weight: 600;
            color: #e6ff94;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            font-family: 'Courier New', monospace;
        }

        .module-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .module-item {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .module-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #e6ff94;
            flex-shrink: 0;
        }

        .module-label {
            font-size: 12px;
            font-weight: 700;
            color: #94a3b8;
            letter-spacing: 0.02em;
            text-transform: uppercase;
        }

        /* Right content */
        .right {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 52px 60px;
            position: relative;
            background: #f0f4f8;
        }

        /* Subtle grid dots */
        .right::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: radial-gradient(circle, #cbd5e1 1px, transparent 1px);
            background-size: 28px 28px;
            opacity: 0.45;
        }

        .content {
            position: relative;
            z-index: 1;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #e6ff94;
            color: #0f172a;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            padding: 4px 12px;
            border-radius: 99px;
            margin-bottom: 22px;
        }

        .headline {
            font-size: 42px;
            font-weight: 900;
            color: #0f172a;
            letter-spacing: -0.035em;
            line-height: 1.1;
            margin-bottom: 18px;
            max-width: 560px;
        }

        .headline em {
            font-style: normal;
            color: #334155;
        }

        .subline {
            font-size: 16px;
            font-weight: 500;
            color: #475569;
            line-height: 1.5;
            max-width: 500px;
            margin-bottom: 36px;
        }

        .stats-row {
            display: flex;
            gap: 28px;
        }

        .stat {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .stat-value {
            font-size: 26px;
            font-weight: 900;
            color: #0f172a;
            letter-spacing: -0.03em;
            font-variant-numeric: tabular-nums;
        }

        .stat-label {
            font-size: 11px;
            font-weight: 600;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .stat-divider {
            width: 1px;
            background: #e2e8f0;
            align-self: stretch;
        }
    </style>
</head>
<body>
    <!-- Left dark panel -->
    <div class="left">
        <div>
            <svg class="logo-mark" viewBox="0 0 256 256" xmlns="http://www.w3.org/2000/svg">
                <path fill="#e6ff94" fill-rule="evenodd" d="M68 55C61.37 55 56 60.37 56 67V211C56 217.63 61.37 223 68 223H92C98.63 223 104 217.63 104 211V163L152 211C156.69 215.69 163.31 215.69 168 211L196 183C200.69 178.31 200.69 171.69 196 167L152 123L196 79C200.69 74.31 200.69 67.69 196 63L168 35C163.31 30.31 156.69 30.31 152 35L104 83V67C104 60.37 98.63 55 92 55H68ZM126 125A14 14 0 1 0 126 153A14 14 0 1 0 126 125Z"/>
            </svg>
            <div class="brand-name">Kinerja</div>
            <div class="domain" style="margin-top: 6px;">kinerja.web.id</div>
        </div>

        <div class="module-list">
            <div class="module-item">
                <div class="module-dot"></div>
                <span class="module-label">Lacak Resi Bansos</span>
            </div>
            <div class="module-item">
                <div class="module-dot"></div>
                <span class="module-label">Peta Anomali</span>
            </div>
            <div class="module-item">
                <div class="module-dot"></div>
                <span class="module-label">Lapor Pungli</span>
            </div>
            <div class="module-item">
                <div class="module-dot"></div>
                <span class="module-label">Scorecard SLA</span>
            </div>
        </div>
    </div>

    <!-- Right content -->
    <div class="right">
        <div class="content">
            <div class="badge">Transparansi Bansos</div>

            <h1 class="headline">
                Bansos Adalah<br>
                Hak Warga.<br>
                <em>Pastikan Sampai Utuh.</em>
            </h1>

            <p class="subline">
                Platform pemantauan bantuan sosial berbasis data publik.
                Lacak, sanggah, dan laporkan: anonim, transparan, terbuka.
            </p>

            <div class="stats-row">
                <div class="stat">
                    <span class="stat-value">5</span>
                    <span class="stat-label">Wilayah Pilot</span>
                </div>
                <div class="stat-divider"></div>
                <div class="stat">
                    <span class="stat-value">72j</span>
                    <span class="stat-label">Target SLA</span>
                </div>
                <div class="stat-divider"></div>
                <div class="stat">
                    <span class="stat-value">100%</span>
                    <span class="stat-label">Anonim</span>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
