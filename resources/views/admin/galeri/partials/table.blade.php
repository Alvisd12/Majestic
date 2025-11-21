<div class="modern-card-body">
    <div class="table-container">
        <table class="modern-table">
            <thead class="modern-thead">
                <tr>
                    <th class="number-col">No</th>
                    <th class="image-col"></th>
                    <th class="user-col">Penulis</th>
                    <th class="jenis-col">Jenis Motor</th>
                    <th class="rental-date-col">Tanggal Sewa</th>
                    <th class="upload-date-col">Tanggal Upload</th>
                    <th class="action-col">Aksi</th>
                </tr>
            </thead>
            <tbody class="modern-tbody">
                @forelse($galeri as $index => $item)
                <tr class="table-row" data-id="{{ $item->id }}">
                    <td class="number-col">
                        <span class="row-number">{{ $galeri->firstItem() + $index }}</span>
                    </td>
                    <td class="image-col">
                        <div class="gallery-image-wrapper">
                            @if($item->gambar)
                                <div class="image-preview-container">
                                    <img src="{{ asset('storage/' . $item->gambar) }}" 
                                         alt="Galeri Image" 
                                         class="gallery-preview-image"
                                         data-image="{{ $item->gambar }}"
                                         data-author="{{ $item->admin->nama ?? 'Admin' }}"
                                         data-date="{{ $item->tanggal_sewa ? \Carbon\Carbon::parse($item->tanggal_sewa)->format('d M Y') . ' - ' . dayNameIndonesian($item->tanggal_sewa) : 'Tanggal tidak tersedia' }}"
                                         onclick="viewGalleryImageFromData(this)">
                                    <div class="image-overlay">
                                        <i class="fas fa-eye"></i>
                                    </div>
                                </div>
                            @else
                                <div class="no-image-placeholder">
                                    <i class="fas fa-image"></i>
                                </div>
                            @endif
                        </div>
                    </td>
                    <td class="user-col">
                        <div class="user-info">
                            <div class="user-details">
                                <div class="user-name">
                                    <i class="fas fa-user me-1"></i>
                                    {{ $item->admin->nama ?? 'Admin' }}
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="jenis-col">
                        @if($item->jenis_motor)
                            <div class="jenis-badge">
                                @php
                                    $jenisColors = [
                                        'Matic' => 'badge-primary',
                                        'Manual' => 'badge-success', 
                                        'Sport' => 'badge-danger'
                                    ];
                                    $colorClass = $jenisColors[$item->jenis_motor] ?? 'badge-secondary';
                                @endphp
                                <span class="badge {{ $colorClass }}">
                                    {{ $item->jenis_motor }}
                                </span>
                            </div>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td class="rental-date-col">
                        @if($item->tanggal_sewa)
                            <div class="date-info">
                                <div class="date">{{ \Carbon\Carbon::parse($item->tanggal_sewa)->format('M d, Y') }}</div>
                                <div class="day">{{ dayNameIndonesian($item->tanggal_sewa) }}</div>
                            </div>
                        @else
                            <span class="no-date">-</span>
                        @endif
                    </td>
                    <td class="upload-date-col">
                        <div class="date-info">
                            <div class="date">{{ \Carbon\Carbon::parse($item->created_at)->format('M d, Y') }}</div>
                            <div class="day">{{ dayNameIndonesian($item->created_at) }}</div>
                        </div>
                    </td>
                    <td class="action-col">
                        <div class="action-buttons">
                            <button type="button" class="action-btn view-btn" 
                                    data-image="{{ $item->gambar }}"
                                    data-author="{{ $item->admin->nama ?? 'Admin' }}"
                                    data-date="{{ $item->tanggal_sewa ? \Carbon\Carbon::parse($item->tanggal_sewa)->format('d M Y') . ' - ' . dayNameIndonesian($item->tanggal_sewa) : 'Tanggal tidak tersedia' }}"
                                    onclick="viewGalleryImageFromData(this)" 
                                    title="Lihat Gambar">
                                <i class="fas fa-eye"></i>
                            </button>
                            <a href="{{ route('admin.galeri.edit', $item->id) }}" 
                               class="action-btn edit-btn" 
                               title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button" class="action-btn delete-btn" 
                                    onclick="deleteGalleryItem('{{ $item->id }}')" 
                                    title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="empty-state">
                        <div class="empty-icon">
                            <i class="fas fa-images"></i>
                        </div>
                        <h5>Tidak ada foto galeri</h5>
                        <p>Belum ada foto yang diupload ke galeri</p>
                        <div class="empty-actions">
                            <a href="{{ route('admin.galeri.create') }}" class="modern-btn modern-btn-primary">
                                <i class="fas fa-plus me-2"></i>
                                Tambah Foto Pertama
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($galeri->hasPages())
<div class="modern-pagination">
    <div class="pagination-info">
        <div class="showing-info">
            Menampilkan {{ $galeri->firstItem() }} - {{ $galeri->lastItem() }} dari {{ $galeri->total() }} foto
        </div>
    </div>
    <div class="pagination-links">
        {{ $galeri->appends(request()->query())->links('vendor.pagination.custom-inline') }}
    </div>
</div>
@endif
