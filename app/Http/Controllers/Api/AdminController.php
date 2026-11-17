<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Certification;
use App\Models\ContactMessage;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Profile;
use App\Models\Project;
use App\Models\ProjectImage;
use App\Models\Skill;
use App\Models\SocialLink;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    /**
     * Dashboard statistics overview.
     */
    public function getOverview(): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data' => [
                'total_projects' => Project::count(),
                'featured_projects' => Project::where('is_featured', true)->count(),
                'total_skills' => Skill::count(),
                'total_experiences' => Experience::count(),
                'total_education' => Education::count(),
                'total_certifications' => Certification::count(),
                'total_messages' => ContactMessage::count(),
                'unread_messages' => ContactMessage::where('is_read', false)->count(),
                'latest_messages' => ContactMessage::latest()->limit(5)->get(),
            ]
        ]);
    }

    // ==========================================
    // PROFILE & RESUME MANAGEMENT
    // ==========================================

    public function getProfile(): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data' => Profile::first()
        ]);
    }

    public function updateProfile(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'title' => 'required|string|max:150',
            'tagline' => 'nullable|string|max:255',
            'short_intro' => 'required|string|max:1000',
            'career_objective' => 'nullable|string|max:2000',
            'bio' => 'nullable|string',
            'phone' => 'nullable|string|max:30',
            'email' => 'required|email|max:100',
            'location' => 'nullable|string|max:150',
            'avatar_url' => 'nullable|string|max:255',
            'resume_path' => 'nullable|string|max:255',
            'strengths' => 'nullable|array',
            'interests' => 'nullable|array',
            'stats' => 'nullable|array',
        ]);

        $profile = Profile::first();
        if (!$profile) {
            $profile = Profile::create($validated);
        } else {
            $profile->update($validated);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Profile updated successfully',
            'data' => $profile
        ]);
    }

    public function uploadResume(Request $request): JsonResponse
    {
        $request->validate([
            'resume' => 'required|file|mimes:pdf|max:10240', // Max 10MB PDF
        ]);

        $file = $request->file('resume');
        $fileName = 'Malavika_MM_Resume_' . time() . '.pdf';
        
        // Save to public storage
        $path = $file->storeAs('resumes', $fileName, 'public');
        $publicUrl = '/storage/' . $path;

        $profile = Profile::first();
        if ($profile) {
            $profile->resume_path = $publicUrl;
            $profile->save();
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Resume PDF uploaded successfully',
            'url' => $publicUrl
        ]);
    }

    public function uploadAvatar(Request $request): JsonResponse
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,webp,svg|max:5120', // Max 5MB
        ]);

        $file = $request->file('avatar');
        $fileName = 'avatar_' . time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('avatars', $fileName, 'public');
        $publicUrl = '/storage/' . $path;

        $profile = Profile::first();
        if ($profile) {
            $profile->avatar_url = $publicUrl;
            $profile->save();
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Profile avatar uploaded successfully',
            'url' => $publicUrl
        ]);
    }

    // ==========================================
    // SKILLS CRUD
    // ==========================================

    public function getSkills(): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data' => Skill::orderBy('display_order')->get()
        ]);
    }

    public function storeSkill(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'category' => 'required|string|max:50',
            'proficiency' => 'required|integer|min:1|max:100',
            'level_label' => 'nullable|string|max:50',
            'icon' => 'nullable|string|max:50',
            'display_order' => 'nullable|integer',
            'is_featured' => 'nullable|boolean',
        ]);

        $skill = Skill::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Skill added successfully',
            'data' => $skill
        ], 201);
    }

    public function updateSkill(Request $request, $id): JsonResponse
    {
        $skill = Skill::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'category' => 'required|string|max:50',
            'proficiency' => 'required|integer|min:1|max:100',
            'level_label' => 'nullable|string|max:50',
            'icon' => 'nullable|string|max:50',
            'display_order' => 'nullable|integer',
            'is_featured' => 'nullable|boolean',
        ]);

        $skill->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Skill updated successfully',
            'data' => $skill
        ]);
    }

    public function deleteSkill($id): JsonResponse
    {
        $skill = Skill::findOrFail($id);
        $skill->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Skill removed successfully'
        ]);
    }

    // ==========================================
    // PROJECTS CRUD & UPLOADS
    // ==========================================

    public function getProjects(): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data' => Project::with('images')->orderBy('display_order')->get()
        ]);
    }

    public function storeProject(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:150',
            'category' => 'required|string|max:50',
            'short_description' => 'required|string|max:500',
            'full_description' => 'nullable|string',
            'problem_statement' => 'nullable|string',
            'features' => 'nullable|array',
            'technologies' => 'nullable|array',
            'highlights' => 'nullable|array',
            'image_url' => 'nullable|string|max:255',
            'github_url' => 'nullable|string|max:255',
            'live_url' => 'nullable|string|max:255',
            'is_featured' => 'nullable|boolean',
            'display_order' => 'nullable|integer',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        
        // Ensure unique slug
        $count = Project::where('slug', 'like', $validated['slug'] . '%')->count();
        if ($count > 0) {
            $validated['slug'] .= '-' . ($count + 1);
        }

        $project = Project::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Project created successfully',
            'data' => $project
        ], 201);
    }

    public function updateProject(Request $request, $id): JsonResponse
    {
        $project = Project::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:150',
            'category' => 'required|string|max:50',
            'short_description' => 'required|string|max:500',
            'full_description' => 'nullable|string',
            'problem_statement' => 'nullable|string',
            'features' => 'nullable|array',
            'technologies' => 'nullable|array',
            'highlights' => 'nullable|array',
            'image_url' => 'nullable|string',
            'github_url' => 'nullable|string',
            'live_url' => 'nullable|string',
            'is_featured' => 'nullable|boolean',
            'display_order' => 'nullable|integer',
        ]);

        $project->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Project updated successfully',
            'data' => $project->fresh(['images'])
        ]);
    }

    public function uploadProjectImage(Request $request, $id): JsonResponse
    {
        $project = Project::findOrFail($id);

        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,webp,svg|max:5120',
            'caption' => 'nullable|string|max:100',
        ]);

        $file = $request->file('image');
        $fileName = 'proj_' . $project->id . '_' . time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('projects', $fileName, 'public');
        $publicUrl = '/storage/' . $path;

        if ($request->boolean('is_thumbnail', false) || empty($project->image_url)) {
            $project->image_url = $publicUrl;
            $project->save();
        }

        $img = ProjectImage::create([
            'project_id' => $project->id,
            'image_url' => $publicUrl,
            'caption' => $request->input('caption'),
            'display_order' => ProjectImage::where('project_id', $project->id)->count() + 1,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Project image uploaded successfully',
            'data' => $img,
            'project' => $project->fresh(['images'])
        ]);
    }

    public function deleteProject($id): JsonResponse
    {
        $project = Project::findOrFail($id);
        $project->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Project deleted successfully'
        ]);
    }

    // ==========================================
    // EDUCATION CRUD
    // ==========================================

    public function getEducation(): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data' => Education::orderBy('display_order')->get()
        ]);
    }

    public function storeEducation(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'degree' => 'required|string|max:150',
            'institution' => 'required|string|max:150',
            'university' => 'nullable|string|max:150',
            'location' => 'nullable|string|max:100',
            'duration' => 'required|string|max:50',
            'cgpa' => 'nullable|string|max:20',
            'description' => 'nullable|string',
            'highlights' => 'nullable|array',
            'display_order' => 'nullable|integer',
        ]);

        $education = Education::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Education entry added successfully',
            'data' => $education
        ], 201);
    }

    public function updateEducation(Request $request, $id): JsonResponse
    {
        $education = Education::findOrFail($id);
        $validated = $request->validate([
            'degree' => 'required|string|max:150',
            'institution' => 'required|string|max:150',
            'university' => 'nullable|string|max:150',
            'location' => 'nullable|string|max:100',
            'duration' => 'required|string|max:50',
            'cgpa' => 'nullable|string|max:20',
            'description' => 'nullable|string',
            'highlights' => 'nullable|array',
            'display_order' => 'nullable|integer',
        ]);

        $education->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Education entry updated successfully',
            'data' => $education
        ]);
    }

    public function deleteEducation($id): JsonResponse
    {
        $education = Education::findOrFail($id);
        $education->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Education entry removed'
        ]);
    }

    // ==========================================
    // EXPERIENCE CRUD
    // ==========================================

    public function getExperience(): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data' => Experience::orderBy('display_order')->get()
        ]);
    }

    public function storeExperience(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'company' => 'required|string|max:150',
            'position' => 'required|string|max:150',
            'location' => 'nullable|string|max:100',
            'start_date' => 'required|string|max:50',
            'end_date' => 'nullable|string|max:50',
            'is_current' => 'nullable|boolean',
            'description' => 'required|string',
            'technologies' => 'nullable|array',
            'achievements' => 'nullable|array',
            'display_order' => 'nullable|integer',
        ]);

        $experience = Experience::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Experience entry added',
            'data' => $experience
        ], 201);
    }

    public function updateExperience(Request $request, $id): JsonResponse
    {
        $experience = Experience::findOrFail($id);
        $validated = $request->validate([
            'company' => 'required|string|max:150',
            'position' => 'required|string|max:150',
            'location' => 'nullable|string|max:100',
            'start_date' => 'required|string|max:50',
            'end_date' => 'nullable|string|max:50',
            'is_current' => 'nullable|boolean',
            'description' => 'required|string',
            'technologies' => 'nullable|array',
            'achievements' => 'nullable|array',
            'display_order' => 'nullable|integer',
        ]);

        $experience->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Experience updated successfully',
            'data' => $experience
        ]);
    }

    public function deleteExperience($id): JsonResponse
    {
        $experience = Experience::findOrFail($id);
        $experience->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Experience entry deleted'
        ]);
    }

    // ==========================================
    // CERTIFICATIONS CRUD
    // ==========================================

    public function getCertifications(): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data' => Certification::orderBy('display_order')->get()
        ]);
    }

    public function storeCertification(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:150',
            'issuer' => 'required|string|max:150',
            'issue_date' => 'nullable|string|max:50',
            'credential_id' => 'nullable|string|max:100',
            'credential_url' => 'nullable|url',
            'description' => 'nullable|string',
            'display_order' => 'nullable|integer',
        ]);

        $cert = Certification::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Certification added',
            'data' => $cert
        ], 201);
    }

    public function updateCertification(Request $request, $id): JsonResponse
    {
        $cert = Certification::findOrFail($id);
        $validated = $request->validate([
            'title' => 'required|string|max:150',
            'issuer' => 'required|string|max:150',
            'issue_date' => 'nullable|string|max:50',
            'credential_id' => 'nullable|string|max:100',
            'credential_url' => 'nullable|url',
            'description' => 'nullable|string',
            'display_order' => 'nullable|integer',
        ]);

        $cert->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Certification updated',
            'data' => $cert
        ]);
    }

    public function deleteCertification($id): JsonResponse
    {
        $cert = Certification::findOrFail($id);
        $cert->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Certification deleted'
        ]);
    }

    // ==========================================
    // SOCIAL LINKS CRUD
    // ==========================================

    public function getSocialLinks(): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data' => SocialLink::orderBy('display_order')->get()
        ]);
    }

    public function storeSocialLink(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'platform' => 'required|string|max:50',
            'label' => 'required|string|max:100',
            'url' => 'required|string|max:255',
            'icon' => 'nullable|string|max:50',
            'is_active' => 'nullable|boolean',
            'display_order' => 'nullable|integer',
        ]);

        $link = SocialLink::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Social link added',
            'data' => $link
        ], 201);
    }

    public function updateSocialLink(Request $request, $id): JsonResponse
    {
        $link = SocialLink::findOrFail($id);
        $validated = $request->validate([
            'platform' => 'required|string|max:50',
            'label' => 'required|string|max:100',
            'url' => 'required|string|max:255',
            'icon' => 'nullable|string|max:50',
            'is_active' => 'nullable|boolean',
            'display_order' => 'nullable|integer',
        ]);

        $link->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Social link updated',
            'data' => $link
        ]);
    }

    public function deleteSocialLink($id): JsonResponse
    {
        $link = SocialLink::findOrFail($id);
        $link->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Social link removed'
        ]);
    }

    // ==========================================
    // CONTACT MESSAGES
    // ==========================================

    public function getMessages(): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data' => ContactMessage::latest()->paginate(20)
        ]);
    }

    public function markMessageAsRead($id): JsonResponse
    {
        $message = ContactMessage::findOrFail($id);
        $message->is_read = true;
        $message->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Message marked as read'
        ]);
    }

    public function deleteMessage($id): JsonResponse
    {
        $message = ContactMessage::findOrFail($id);
        $message->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Message deleted'
        ]);
    }
}

