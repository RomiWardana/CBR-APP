<div class="dashboard-header">
    <h2>Riwayat Diagnosa</h2>
    <p>Daftar hasil analisis perangkat yang pernah Anda lakukan.</p>
</div>

<style>
body{
    font-family: 'Plus Jakarta Sans', sans-serif;
    background: #f1f5f9;
}

/* HEADER */
.dashboard-header{
    margin-bottom: 20px;
}

.dashboard-header h2{
    font-size: 28px;
    font-weight: 800;
    color: #0f172a;
}

.dashboard-header p{
    color: #64748b;
}

/* CARD */
.card{
    background: white;
    border-radius: 20px;
    padding: 20px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.06);
}

/* TABLE */
.history-table{
    width: 100%;
    border-collapse: collapse;
    border-radius: 16px;
    overflow: hidden;
}

/* HEADER TABLE */
.history-table thead{
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
}

.history-table th{
    color: white;
    padding: 16px;
    text-align: left;
    font-size: 12px;
    letter-spacing: 1px;
    text-transform: uppercase;
}

/* ROW */
.history-table td{
    padding: 16px;
    border-bottom: 1px solid #eef2f7;
    font-size: 14px;
    color: #1e293b;
    transition: 0.25s ease;
}

/* 🔥 FIX HOVER STABILITY */
.history-table tbody tr{
    transition: 0.25s ease;
}

.history-table tbody tr:hover{
    background: #eef2ff;
    transform: scale(1.01);
}

/* BADGE */
.badge{
    background: #eef2ff;
    color: #6366f1;
    padding: 6px 12px;
    border-radius: 999px;
    font-weight: 700;
    font-size: 12px;
    display: inline-block;
}

/* SOLUSI TEXT */
.small{
    font-size: 12px;
    color: #64748b;
    margin-top: 3px;
}

/* EMPTY */
.empty{
    text-align: center;
    padding: 40px;
    color: #94a3b8;
}
</style>

<div class="card">

<table class="history-table">
    <thead>
        <tr>
            <th>No</th>
            <th>Kasus</th>
            <th>Solusi</th>
            <th>Similarity</th>
            <th>Waktu</th>
        </tr>
    </thead>

    <tbody>
        @php $no = 1; @endphp

        @forelse($riwayat as $row)
            <tr>
                <td>{{ $no++ }}</td>

                <td>
                    <strong>{{ $row->hasil_diagnosa }}</strong>
                    <div class="solusi-text">{{ $row->input_text }}</div>
                </td>

                <td>{{ $row->solusi }}</td>

                <td>
                    <span class="badge">
                        {{ round($row->similarity, 2) }}%
                    </span>
                </td>

                <td class="solusi-text">
                    {{ \Carbon\Carbon::parse($row->created_at)->format('d M Y, H:i') }}
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="empty">Belum ada riwayat diagnosa</td>
            </tr>
        @endforelse
    </tbody>

</table>

</div>