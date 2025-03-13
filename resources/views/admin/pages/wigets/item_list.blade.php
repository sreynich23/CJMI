<div class="border rounded-lg p-6 mb-6">
    <h2 class="text-xl font-semibold mb-4">Recent Journal Issues</h2>
    <!-- Add horizontal scrolling for the table -->
    <div class="overflow-x-auto">
        @foreach ($formattedVolumes as $year => $volumes)
            <h3 class="text-3xl font-bold mb-4 text-center">{{ $year }}</h3>
            <div class="grid grid-cols-4 gap-8 border-b-2 pb-10">
                @foreach ($volumes as $volume)
                    <ul>
                        <li>
                            <a href="{{ route('admin.volume.issue.details', ['id' => $volume['id_volume_issue']]) }}">
                                {{ $volume['volume'] }}
                                @php
                                    $image = \App\Models\VolumeIssueImage::where('volume_issue_id', $volume['id_volume_issue'])->first();
                                @endphp
                                @if ($image && $image->image_path)
                                    <img src="{{ asset('storage/' . $image->image_path) }}" alt="Volume Image"
                                        class="w-9/12 h-auto mt-2">
                                @else
                                    <p>No image available</p>
                                @endif
                            </a>
                        </li>
                    </ul>
                @endforeach
            </div>
        @endforeach
    </div>
</div>
