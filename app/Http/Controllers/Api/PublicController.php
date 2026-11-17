<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Certification;
use App\Models\ContactMessage;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Skill;
use App\Models\SocialLink;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class PublicController extends Controller
{
    /**
     * Get aggregated portfolio data for fast initial load.
     */
    public function getInitialData(): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data' => [
                'profile' => Profile::first(),
                'social_links' => SocialLink::where('is_active', true)->orderBy('display_order')->get(),
                'skills' => Skill::orderBy('display_order')->get(),
                'skills_by_category' => Skill::orderBy('display_order')->get()->groupBy('category'),
                'education' => Education::orderBy('display_order')->get(),
                'experiences' => Experience::orderBy('display_order')->get(),
                'featured_projects' => Project::where('is_featured', true)->orderBy('display_order')->get(),
                'all_projects' => Project::with('images')->orderBy('display_order')->get(),
                'certifications' => Certification::orderBy('display_order')->get(),
            ]
        ]);
    }

    /**
     * Get profile info.
     */
    public function getProfile(): JsonResponse
    {
        $profile = Profile::first();

        return response()->json([
            'status' => 'success',
            'data' => $profile
        ]);
    }

    /**
     * Get all skills.
     */
    public function getSkills(): JsonResponse
    {
        $skills = Skill::orderBy('display_order')->get();

        return response()->json([
            'status' => 'success',
            'data' => $skills,
            'grouped' => $skills->groupBy('category')
        ]);
    }

    /**
     * Get education entries.
     */
    public function getEducation(): JsonResponse
    {
        $education = Education::orderBy('display_order')->get();

        return response()->json([
            'status' => 'success',
            'data' => $education
        ]);
    }

    /**
     * Get work experiences.
     */
    public function getExperience(): JsonResponse
    {
        $experiences = Experience::orderBy('display_order')->get();

        return response()->json([
            'status' => 'success',
            'data' => $experiences
        ]);
    }

    /**
     * Get projects with optional category filter.
     */
    public function getProjects(Request $request): JsonResponse
    {
        $query = Project::with('images')->orderBy('display_order');

        if ($request->has('category') && $request->category !== 'All') {
            $query->where('category', $request->category);
        }

        if ($request->has('featured') && $request->boolean('featured')) {
            $query->where('is_featured', true);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('short_description', 'like', "%{$search}%")
                  ->orWhere('technologies', 'like', "%{$search}%");
            });
        }

        $projects = $query->get();

        // Get unique categories for filter tabs
        $categories = Project::select('category')->distinct()->pluck('category')->prepend('All');

        return response()->json([
            'status' => 'success',
            'categories' => $categories,
            'data' => $projects
        ]);
    }

    /**
     * Get single project details by ID or slug.
     */
    public function getProject($idOrSlug): JsonResponse
    {
        $project = Project::with('images')
            ->where('id', $idOrSlug)
            ->orWhere('slug', $idOrSlug)
            ->first();

        if (!$project) {
            return response()->json([
                'status' => 'error',
                'message' => 'Project not found'
            ], 404);
        }

        // Suggest related projects
        $related = Project::where('id', '!=', $project->id)
            ->where('category', $project->category)
            ->limit(3)
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $project,
            'related' => $related
        ]);
    }

    /**
     * Get certifications.
     */
    public function getCertifications(): JsonResponse
    {
        $certifications = Certification::orderBy('display_order')->get();

        return response()->json([
            'status' => 'success',
            'data' => $certifications
        ]);
    }

    /**
     * Get social links.
     */
    public function getSocialLinks(): JsonResponse
    {
        $links = SocialLink::where('is_active', true)->orderBy('display_order')->get();

        return response()->json([
            'status' => 'success',
            'data' => $links
        ]);
    }

    /**
     * Submit contact form message.
     */
    public function submitContact(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:150',
            'subject' => 'required|string|max:200',
            'message' => 'required|string|min:10|max:3000',
        ]);

        $message = ContactMessage::create([
            'name' => strip_tags($validated['name']),
            'email' => filter_var($validated['email'], FILTER_SANITIZE_EMAIL),
            'subject' => strip_tags($validated['subject']),
            'message' => strip_tags($validated['message']),
            'ip_address' => $request->ip(),
            'is_read' => false,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Thank you for reaching out! Your message has been received, and I will get back to you shortly.',
            'data' => [
                'id' => $message->id,
                'created_at' => $message->created_at->toIso8601String(),
            ]
        ], 201);
    }

    /**
     * Download or serve resume.
     */
    public function downloadResume()
    {
        $profile = Profile::first();

        if ($profile && $profile->resume_path) {
            $relativePath = ltrim(str_replace('/storage/', '', $profile->resume_path), '/\\');
            
            // 1. Check in public/storage/
            $fullPath = public_path('storage/' . $relativePath);
            if (file_exists($fullPath)) {
                return response()->download($fullPath, 'Malavika_MM_Resume.pdf', [
                    'Content-Type' => 'application/pdf',
                ]);
            }

            // 2. Direct check on public_path
            $directPath = public_path(ltrim($profile->resume_path, '/\\'));
            if (file_exists($directPath)) {
                return response()->download($directPath, 'Malavika_MM_Resume.pdf', [
                    'Content-Type' => 'application/pdf',
                ]);
            }
        }

        // Clean fallback redirect to the full interactive Resume page
        return redirect('/resume');
    }
}

