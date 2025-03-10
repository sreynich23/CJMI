@extends('layouts.app')

@section('content')
    <div class="mt-5 bg-white shadow-lg rounded-xl">
        <div class="flex">
            <!-- Sidebar -->
            <div class="w-1/5 lg:p-4 text-white rounded-md">
                <div class="sticky top-24">
                    <button onclick="switchScreen('all-editorials')"
                        class="block text-xs md:text-sm lg:text-base w-full text-left border border-white rounded-md lg:px-4 px-2 py-2 bg-blue-900 hover:bg-blue-900 hover:text-black transition">
                        📖 All Editorials
                    </button>
                    <button onclick="switchScreen('reviewing-policy')"
                        class="block text-xs md:text-sm lg:text-base w-full text-left border border-white rounded-md lg:px-4 px-2 py-2 bg-blue-900 hover:bg-blue-900 hover:text-black transition">
                        📝 Reviewing Policy
                    </button>
                    <button onclick="switchScreen('archiving-policy')"
                        class="block text-xs md:text-sm lg:text-base w-full text-left border border-white rounded-md lg:px-4 px-2 py-2 bg-blue-900 hover:bg-blue-900 hover:text-black transition">
                        📂 Archiving-Policy
                    </button>
                    <button onclick="switchScreen('plagiarism-policy')"
                        class="block text-xs md:text-sm lg:text-base w-full text-left border border-white rounded-md lg:px-4 px-2 py-2 bg-blue-900 hover:bg-blue-900 hover:text-black transition">
                        📑 Plagiarism Policy
                    </button>
                    <button onclick="switchScreen('open-access-policy')"
                        class="block text-xs md:text-sm lg:text-base w-full text-left border border-white rounded-md lg:px-4 px-2 py-2 bg-blue-900 hover:bg-blue-900 hover:text-black transition">
                        🔓 Open Access Policy
                    </button>
                </div>
            </div>
            <!-- Main Content -->
            <div class="flex-1 py-5 px-6">
                <!-- All Editorials Section -->
                <div id="all-editorials" class="page">
                    <h2 class="text-lg font-semibold text-gray-700 mb-4">📚 All Editorials</h2>
                    <div class="space-y-2">
                        @foreach ($teamMembers as $position => $members)
                            <!-- Grouped Position Title -->
                            <p class="text-blue-600 font-bold text-lg">{{ $position }}</p>
                            <!-- Members in the Position -->
                            <div class="space-y-4">
                                @foreach ($members as $member)
                                    <div class="bg-white shadow-md rounded-lg overflow-hidden w-full">
                                        <div class="p-4 lg:flex lg:items-center lg:space-x-4">
                                            @if ($member->path_image)
                                                <img src="{{ asset('storage/' . $member->path_image) }}" height="100"
                                                    width="100">
                                            @endif
                                            <div>
                                            <h5 class="text-xl font-semibold">{{ $member->name }}</h5>
                                            <p class="text-gray-600 mt-2">
                                                {!! Str::of(nl2br(e($member->description)))
                                                    ->replaceMatches('/(https?:\/\/[^\s]+)/', '<a href="$1" class="text-blue-500 hover:underline" target="_blank">$1</a>')  // Links
                                                    ->replaceMatches('/([a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,})/', '<a href="mailto:$1" class="text-blue-500 hover:underline">$1</a>')  // Emails
                                                !!}
                                            </p>
                                        </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                    <h2 class="text-lg font-semibold text-gray-700 mb-4">🔍 All Reviewers</h2>
                    <ul class="list-disc list-inside text-gray-800 space-y-10">
                        @foreach ($reviewers as $reviewer)
                            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                                <div class="p-4 ">
                                    <h5 class="text-xl font-semibold">{{ $reviewer->name }}</h5>
                                    <p class="text-blue-600 font-bold">{{ $reviewer->position }}</p>
                                    <p class="text-gray-600 mt-2">{{ $reviewer->country }}</p>
                                    <p class="text-gray-600 mt-2">{{ $reviewer->expertise }}</p>
                                </div>
                            </div>
                        @endforeach
                    </ul>
                </div>
                <!-- Reviewing Policy Section -->
                <div id="reviewing-policy" class="page hidden">
                    <div class="max-w-4xl mx-auto bg-white lg:p-6 shadow-md rounded-md">
                        <h1 class="text-3xl font-semibold mb-4">Reviewing Policy
                            @guest
                            @else
                                @if (auth()->user()->role === 'user')
                                    <div class="mt-6">
                                        <button data-toggle="reviewer-form"
                                            class="flex text-xs md:text-sm lg:text-base items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition">
                                            ✨ Become a Reviewer
                                        </button>
                                    </div>
                                @endif
                            @endguest
                        </h1>

                        <h2 class="text-xl font-semibold mt-4">Peer Review Policy</h2>
                        <p class="mt-2 text-gray-700">
                            To deal with potential publication misconduct, the CJMRI sets up editorial policies for its
                            editors and authors to follow.
                            These policies are carefully considered based on the CJMRI’s principles of transparency and best
                            practice in scholarly publishing.
                        </p>

                        <h3 class="italic font-semibold mt-4">Model of Peer Review</h3>
                        <p class="mt-2 text-gray-700">
                            The CJMRI runs a <i>double-blind peer review</i> system, in which the reviewers do not know the
                            names or affiliations of the authors, and the reviewer reports provided to the authors stay
                            anonymous.
                        </p>

                        <p class="mt-2 text-gray-700">
                            All manuscripts submitted to the CJMRI are screened by an editor, who is responsible for
                            assessing their compatibility with the CJMRI’s requirements regarding research article
                            structure,
                            referencing, and formatting.
                            Submissions that are deemed suitable will be forwarded for peer review.
                        </p>

                        <p class="mt-2 text-gray-700">
                            The reviewing of the manuscripts will be done by at least 2 reviewers who are experts in the
                            field, following the guidelines for reviewers.
                            The reviewers’ recommendations are only visible to the Editors.
                        </p>

                        <p class="mt-2 text-gray-700">
                            The Editor-in-Chief reviews the reviewers’ reports and makes a final decision about acceptance
                            of the paper (with or without revision) or its rejection.
                        </p>

                        <p class="mt-2 text-gray-700">
                            Authors should note that even in light of one positive report, concerns raised by another
                            reviewer may fundamentally undermine the study and result in the manuscript being rejected.
                        </p>

                        <h3 class="text-lg font-semibold mt-6">Peer Review Process</h3>
                        <ul class="mt-2 list-decimal pl-6 text-gray-700">
                            <li>Any manuscript within the scope of the CJMRI and subject to author guidelines will be
                                assigned to one Editor.</li>
                            <li>All articles published by the CJMRI must pass editorial screening and anonymous double-blind
                                peer review.</li>
                            <li>The CJMRI’s Editorial Office aims to provide a first decision confirmation on submitted
                                manuscripts within 3 months.</li>
                        </ul>

                        <p class="mt-2 text-gray-700">
                            A double-blind peer review process is applied by CJMRI. The reviewing processes are shown in the
                            following figure:
                        </p>

                        <!-- Example of how an image can be included -->
                        <div class="mt-4 flex justify-center">
                            <img src="storage/images/peer-review-process.png" alt="Peer Review Process Diagram"
                                class="w-full max-w-xl">
                        </div>
                    </div>
                </div>
                <!-- Archiving Policy -->
                <div id="archiving-policy" class="page hidden">
                    <div class="max-w-4xl mx-auto bg-white p-6 shadow-md rounded-md">
                        <h1 class="text-3xl font-semibold mb-4">Archiving Policy</h1>
                        <p class="mt-2 text-gray-700">
                            The Cambodia Journal of Multidisciplinary Research and Innovation utilizes the LOCKSS (Lots of
                            Copies Keep
                            Stuff Safe) system to create a distributed archiving system among participating libraries, and
                            it permits those libraries to create permanent archives of the journal for purposes of
                            preservation and restoration. The full text of all articles published in the Journal of
                            International Economics and Management is deposited in the Public Knowledge Project’s Private
                            LOCKSS Network (PKP-PLN) to guarantee long-term digital preservation.

                            Papers submitted to CJMRI should not have been published before in their current or
                            substantially
                            similar content, or be under consideration for publication.

                            All submitted papers must be original work. Authors submitting articles for publication warrant
                            that the work is not an infringement of any existing copyright and will indemnify the publisher
                            against any breach of such warran.

                            This is an open-access journal. All the content of CJMRI's articles from 11/2019 onward is
                            subject to be published under the Creative Commons Attribution-NonCommercial 4.0 International
                            License (CC BY-NC 4.0). This license permits unrestricted non-commercial use, distribution, and
                            reproduction in any medium, provided the original work is properly cited. Authors agree to make
                            articles legally available for reuse, without permission or fees, for virtually any purpose.
                        </p>

                        <h3 class="italic font-semibold mt-4">Third-party Copyright Permissions</h3>
                        <p class="mt-2 text-gray-700">
                            Before submitting a paper to CJMRI, authors are responsible to get permission to use any content
                            that has not been created by them.

                            Failure to do so may lead to lengthy delay in publication. CJMRI is unable to publish an article
                            that has permission pending. The rights that CJMRI requires are:

                            Non-exclusive rights to reproduce the material in the articles;

                            Print and electronic rights;

                            Worldwide English language rights;

                            Using the material for the life of the work (i.e. there should be no time restrictions on the
                            re-use of material, e.g. a one-year license).
                        </p>
                        <h3 class="italic font-semibold mt-4">When reproducing tables, figures, or excerpts (of more than
                            250 words) from another source, it is required that:</h3>
                        <p class="mt-2 text-gray-700">
                            Authors obtain the necessary written permission in advance from third-party owners of copyrights
                            for the use in print and electronic formats of any of their text, illustrations, graphics, or
                            any other material in their manuscript. Permission must also be obtained for any minor
                            adaptations of any work not created by authors.

                            If authors adapt any material significantly, they must inform the copyright holders of the
                            original work.

                            Authors obtain any proof of consent statement.

                            Authors must acknowledge the source in figure captions and refer to that source in the reference
                            list.

                            Authors should not assume that any content which is freely available on websites is free to use.
                            Authors should check the websites for details of the copyright holders to seek permission for
                            re-use.
                        </p>
                    </div>
                </div>
                <!-- Plagiarism Policy -->
                <div id="plagiarism-policy" class="page hidden">
                    <div class="max-w-4xl mx-auto bg-white p-6 shadow-md rounded-md">
                        <h1 class="text-3xl font-semibold mb-4">Plagiarism Policy</h1>
                        <p class="mt-2 text-gray-700">
                            By submitting a manuscript to CJMRI, the authors commit that the work is original, free of
                            fabrication or falsification, and does not contain any duplication of the authors' own work.

                            Referencing all related work is required. To ensure writing and research integrity, CJMRI
                            employs
                            the iThenticate plagiarism detection system to check all manuscripts for duplicate and
                            unattributed content.

                            In preventing plagiarism from occurring, we request the reviewers notify the editors when
                            suspecting plagiarism, fraud, or other ethical concerns. Details are found in the Review Form.
                        </p>
                    </div>
                </div>
                <!-- Open access Policy -->
                <div id="open-access-policy" class="page hidden">
                    <div class="max-w-4xl mx-auto bg-white p-6 shadow-md rounded-md">
                        <h1 class="text-3xl font-semibold mb-4">Open Access Policy</h1>
                        <p class="mt-2 text-gray-700">
                            All articles published by CJMRI are open-access. This means there are no financial, legal, or
                            technical barriers to accessing them, making research information available to readers at no
                            cost. Readers are allowed to use the articles published in CJMRI for any other lawful and
                            non-commercial purpose, in accordance with a Creative Commons Attribution-NonCommercial 4.0
                            International License (CC BY-NC 4.0).
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reviewer Form Modal -->
    <div id="reviewerFormModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="w-full max-w-lg bg-white rounded-lg shadow-lg p-6">
            <h1 class="text-2xl font-bold text-center text-gray-800 mb-6">Request to Become a Reviewer</h1>
            <form action="{{ route('reviewer.create') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- CV Upload -->
                <div class="mb-4">
                    <label for="cv" class="block font-medium text-gray-700">Upload CV (PDF)</label>
                    <input type="file" name="cv" id="cv"
                        class="w-full border px-3 py-2 rounded-lg focus:ring-2 focus:ring-blue-500 transition"
                        accept="application/pdf" required />
                </div>

                <!-- Position -->
                <div class="mb-4">
                    <label for="position" class="block font-medium text-gray-700">Position</label>
                    <input type="text" name="position" id="position"
                        class="w-full border px-3 py-2 rounded-lg focus:ring-2 focus:ring-blue-500 transition"
                        placeholder="e.g., AI Specialist" required />
                </div>

                <!-- Expertise -->
                <div class="mb-4">
                    <label for="expertise" class="block font-medium text-gray-700">Expertise</label>
                    <input type="text" name="expertise" id="expertise"
                        class="w-full border px-3 py-2 rounded-lg focus:ring-2 focus:ring-blue-500 transition"
                        placeholder="e.g., Data Science" required />
                </div>

                <!-- Terms and Conditions -->
                <div class="flex items-center mb-6">
                    <input type="checkbox" id="terms" name="terms"
                        class="w-5 h-5 text-blue-500 border-gray-300 rounded">
                    <label for="terms" class="ml-2 text-sm text-gray-600">
                        I agree to the <a href="#" class="text-blue-500 underline">terms and conditions</a>.
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="w-full px-4 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition">
                    Request Reviewer Role
                </button>
            </form>
        </div>
    </div>

    <script>
        function switchScreen(screenId) {
            window.location.hash = screenId;
            document.querySelectorAll('.page').forEach(page => page.classList.add('hidden'));
            document.getElementById(screenId)?.classList.remove('hidden');
        }

        window.addEventListener('load', () => switchScreen(location.hash.substring(1) || 'allEditorials'));
        window.addEventListener('hashchange', () => switchScreen(location.hash.substring(1)));


        document.addEventListener('DOMContentLoaded', function() {
            const toggleButton = document.querySelector('[data-toggle="reviewer-form"]');
            const formModal = document.querySelector('#reviewerFormModal');

            if (toggleButton && formModal) {
                toggleButton.addEventListener('click', () => {
                    formModal.classList.toggle('hidden');
                });

                document.addEventListener('click', (event) => {
                    if (!formModal.contains(event.target) && !toggleButton.contains(event.target)) {
                        formModal.classList.add('hidden');
                    }
                });
            }
        });
    </script>
@endsection
