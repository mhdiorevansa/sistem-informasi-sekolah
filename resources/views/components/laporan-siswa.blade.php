<div class="mb-4 flex flex-col gap-y-3">
		<h2 class="capitalize"><span class="inline-block" style="width: 130px;">Nama</span>: {{ $siswa->nama_lengkap }}</h2>
		<h2 class="capitalize"><span class="inline-block" style="width: 130px;">Nis</span>: {{ $siswa->nis }}</h2>
		<h2 class="capitalize"><span class="inline-block" style="width: 130px;">Tanggal Lahir</span>: {{ $siswa->tanggal_lahir }}
		</h2>
		<h2 class="capitalize"><span class="inline-block" style="width: 130px;">Jenis Kelamin</span>: {{ $siswa->gender }}
		</h2>
</div>

@foreach ($groupedRaports as $groupKey => $raports)
		<div class="mb-1">
				<h3 class="font-semibold">Kelas {{ $groupKey }}</h3>
		</div>
		<table class="min-w-full">
				<thead>
						<tr class="border-b border-t">
								<th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Mata Pelajaran</th>
								<th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Alfa</th>
								<th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Izin</th>
								<th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Sakit</th>
								<th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Nilai</th>
								<th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Keaktifan</th>
						</tr>
				</thead>
				<tbody>
						@foreach ($raports as $raport)
								@php
										$totalNilai = $raport->nilaiLaporanSiswa->sum('nilai');
										$jumlahMapel = $raport->nilaiLaporanSiswa
											->filter(function ($nilai) use ($raport) {
												return $nilai->mataPelajaran->kelas_id == $raport->kelas_id;
											})
											->count();
										$rataRataNilai = $jumlahMapel > 0 ? $totalNilai / $jumlahMapel : 0;
								@endphp
								@foreach ($raport->nilaiLaporanSiswa as $nilai)
										<tr class="border-b border-t">
												<td class="px-6 py-4 text-sm text-gray-900">
														{{ $nilai->mataPelajaran->mata_pelajaran ?? '-' }}
												</td>
												<td class="px-6 py-4 text-sm text-gray-900">
														{{ $nilai->alfa ?? '-' }}
												</td>
												<td class="px-6 py-4 text-sm text-gray-900">
														{{ $nilai->izin ?? '-' }}
												</td>
												<td class="px-6 py-4 text-sm text-gray-900">
														{{ $nilai->sakit ?? '-' }}
												</td>
												<td class="px-6 py-4 text-sm text-gray-900">
														{{ $nilai->nilai ?? '-' }}
												</td>
												<td class="px-6 py-4 text-sm text-gray-900">
														{{ $nilai->keaktifan ?? '-' }}
												</td>
										</tr>
								@endforeach
								<tr class="border-b">
										<th class="px-6 py-3 text-end text-sm font-semibold" colspan="6">Total Nilai :
												{{ number_format($rataRataNilai, 2) }}
										</th>
								</tr>
						@endforeach
				</tbody>
		</table>
@endforeach
