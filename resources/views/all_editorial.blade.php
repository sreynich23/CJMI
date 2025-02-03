@extends('layouts.app')

@section('content')
    <div class="mt-5 bg-white shadow-lg rounded-xl">
        <div class="flex">
            <!-- Sidebar -->
            <div class="w-1/5 p-4 text-white rounded-md">
                <div class="sticky top-24">
                    <button onclick="switchScreen('allEditorials')"
                        class="block w-full text-left border border-white rounded-md px-4 py-2 bg-green-500 hover:bg-green-500 hover:text-green-800 transition">
                        📖 All Editorials
                    </button>
                    <button onclick="switchScreen('reviewing-policy')"
                        class="block w-full text-left border border-white rounded-md px-4 py-2 bg-green-500 hover:bg-green-500 hover:text-green-800 transition">
                        📝 Reviewing Policy
                    </button>
                    <button onclick="switchScreen('archiving-policy')"
                        class="block w-full text-left border border-white rounded-md px-4 py-2 bg-green-500 hover:bg-green-500 hover:text-green-800 transition">
                        📂 Archiving-Policy
                    </button>
                </div>
            </div>
            <!-- Main Content -->
            <div class="flex-1 py-5 px-6">
                <!-- All Editorials Section -->
                <div id="allEditorials" class="page">
                    <h2 class="text-lg font-semibold text-gray-700 mb-4">📚 All Editorials</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($teamMembers as $member)
                            <div class="bg-white shadow-md rounded-lg overflow-hidden transform transition hover:scale-105">
                                <div class="p-4 text-center">
                                    <h5 class="text-xl font-semibold">{{ $member->name }}</h5>
                                    <p class="text-green-600 font-bold">{{ $member->position }}</p>
                                    <p class="text-gray-600 mt-2">{{ $member->description }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <h2 class="text-lg font-semibold text-gray-700 mb-4">🔍 All Reviewers</h2>
                    <ul class="list-disc list-inside text-gray-800 space-y-10">
                        @foreach ($reviewers as $reviewer)
                            <div class="bg-white shadow-md rounded-lg overflow-hidden transform transition ">
                                <div class="p-4 ">
                                    <h5 class="text-xl font-semibold">{{ $reviewer->name }}</h5>
                                    <p class="text-green-600 font-bold">{{ $reviewer->position }}</p>
                                    <p class="text-gray-600 mt-2">{{ $reviewer->country }}</p>
                                    <p class="text-gray-600 mt-2">{{ $reviewer->expertise }}</p>
                                </div>
                            </div>
                        @endforeach
                    </ul>
                </div>
                <!-- Reviewing Policy Section -->
                <div id="reviewing-policy" class="page hidden">
                    <div class="max-w-4xl mx-auto bg-white p-6 shadow-md rounded-md">
                        <h1 class="text-3xl font-semibold mb-4">Reviewing Policy
                            @guest
                            @else
                                @if (auth()->user()->role === 'user')
                                    <div class="mt-6">
                                        <button data-toggle="reviewer-form"
                                            class="flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition">
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
                            <img src="https://jiem.ftu.edu.vn/public/site/images/admin/qtta3.jpg"
                                alt="Peer Review Process Diagram" class="w-full max-w-xl">
                        </div>
                    </div>
                </div>
                <div id="archiving-policy" class="page hidden">
                    <div class="max-w-4xl mx-auto bg-white p-6 shadow-md rounded-md">
                        <h1 class="text-3xl font-semibold mb-4">Archiving Policy</h1>
                        <p class="mt-2 text-gray-700">
                            The Journal of International Economics and Management utilizes the LOCKSS (Lots of Copies Keep
                            Stuff Safe) system to create a distributed archiving system among participating libraries, and
                            it permits those libraries to create permanent archives of the journal for purposes of
                            preservation and restoration. The full text of all articles published in the Journal of
                            International Economics and Management is deposited in the Public Knowledge Project’s Private
                            LOCKSS Network (PKP-PLN) to guarantee long-term digital preservation.

                            Papers submitted to JIEM should not have been published before in their current or substantially
                            similar content, or be under consideration for publication.

                            All submitted papers must be original work. Authors submitting articles for publication warrant
                            that the work is not an infringement of any existing copyright and will indemnify the publisher
                            against any breach of such warran.

                            This is an open-access journal. All the content of JIEM's articles from 11/2019 onward is
                            subject to be published under the Creative Commons Attribution-NonCommercial 4.0 International
                            License (CC BY-NC 4.0). This license permits unrestricted non-commercial use, distribution, and
                            reproduction in any medium, provided the original work is properly cited. Authors agree to make
                            articles legally available for reuse, without permission or fees, for virtually any purpose.
                        </p>

                        <h3 class="italic font-semibold mt-4">Third-party Copyright Permissions</h3>
                        <p class="mt-2 text-gray-700">
                            Before submitting a paper to JIEM, authors are responsible to get permission to use any content
                            that has not been created by them.

                            Failure to do so may lead to lengthy delay in publication. JIEM is unable to publish an article
                            that has permission pending. The rights that JIEM requires are:

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
            document.querySelectorAll('.page').forEach((page) => {
                page.classList.add('hidden');
            });
            document.getElementById(screenId).classList.remove('hidden');
        }

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
