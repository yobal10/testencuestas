<?php

namespace Database\Seeders;

use App\Models\AcademicCourse;
use App\Models\AcademicPeriod;
use App\Models\AcademicProgram;
use App\Models\Faculty;
use App\Models\Survey;
use App\Models\SurveyQuestion;
use App\Models\UniversityMember;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UniversityAcademicSeeder extends Seeder
{
    public function run(): void
    {
        $faculties = [
            ['name' => 'Facultad de Ingeniería y Tecnología', 'code' => 'FIT', 'slug' => 'ingenieria-y-tecnologia', 'dean_name' => 'Dirección Académica'],
            ['name' => 'Facultad de Ciencias Empresariales', 'code' => 'FCE', 'slug' => 'ciencias-empresariales', 'dean_name' => 'Dirección Académica'],
            ['name' => 'Facultad de Ciencias de la Salud', 'code' => 'FCS', 'slug' => 'ciencias-de-la-salud', 'dean_name' => 'Dirección Académica'],
            ['name' => 'Facultad de Educación y Humanidades', 'code' => 'FEH', 'slug' => 'educacion-y-humanidades', 'dean_name' => 'Dirección Académica'],
        ];

        foreach ($faculties as $facultyData) {
            $faculty = Faculty::updateOrCreate(
                ['code' => $facultyData['code']],
                $facultyData + ['description' => 'Unidad académica de Campus Pulse University', 'is_active' => true]
            );

            $programs = match ($faculty->code) {
                'FIT' => [
                    ['name' => 'Ingeniería de Sistemas', 'code' => 'IS', 'degree_level' => 'pregrado'],
                    ['name' => 'Ingeniería Industrial', 'code' => 'II', 'degree_level' => 'pregrado'],
                ],
                'FCE' => [
                    ['name' => 'Administración de Empresas', 'code' => 'AE', 'degree_level' => 'pregrado'],
                    ['name' => 'Contabilidad', 'code' => 'CO', 'degree_level' => 'pregrado'],
                ],
                'FCS' => [
                    ['name' => 'Enfermería', 'code' => 'ENF', 'degree_level' => 'pregrado'],
                    ['name' => 'Psicología', 'code' => 'PSI', 'degree_level' => 'pregrado'],
                ],
                default => [
                    ['name' => 'Educación Inicial', 'code' => 'EI', 'degree_level' => 'pregrado'],
                    ['name' => 'Comunicación', 'code' => 'COM', 'degree_level' => 'pregrado'],
                ],
            };

            foreach ($programs as $programData) {
                $program = AcademicProgram::updateOrCreate(
                    ['code' => $programData['code']],
                    $programData + [
                        'faculty_id' => $faculty->id,
                        'slug' => Str::slug($programData['name']),
                        'duration_semesters' => 10,
                        'is_active' => true,
                    ]
                );

                foreach ([
                    ['code' => $program->code . '-101', 'name' => 'Introducción a la carrera', 'semester_level' => 1, 'credits' => 3],
                    ['code' => $program->code . '-201', 'name' => 'Metodología de la investigación', 'semester_level' => 2, 'credits' => 4],
                    ['code' => $program->code . '-301', 'name' => 'Gestión de proyectos académicos', 'semester_level' => 3, 'credits' => 3],
                ] as $courseData) {
                    AcademicCourse::updateOrCreate(
                        ['program_id' => $program->id, 'code' => $courseData['code']],
                        $courseData + ['is_active' => true]
                    );
                }
            }
        }

        $period = AcademicPeriod::updateOrCreate(
            ['code' => '2026-I'],
            [
                'name' => 'Periodo académico 2026-I',
                'starts_on' => '2026-03-16',
                'ends_on' => '2026-07-31',
                'status' => 'active',
            ]
        );

        $admin = User::where('email', 'admin@example.com')->first();

        if (! $admin) {
            return;
        }

        UniversityMember::updateOrCreate(
            ['user_id' => $admin->id],
            [
                'member_type' => 'administrator',
                'status' => 'active',
                'profile_data' => ['area' => 'Gestión institucional'],
            ]
        );

        $survey = Survey::updateOrCreate(
            ['slug' => 'evaluacion-experiencia-estudiantil-2026-i'],
            [
                'created_by' => $admin->id,
                'academic_period_id' => $period->id,
                'title' => 'Evaluación de la experiencia estudiantil 2026-I',
                'description' => 'Conoce la percepción de la comunidad estudiantil sobre cursos, docentes y servicios universitarios.',
                'survey_type' => 'student_experience',
                'audience' => 'students',
                'status' => 'published',
                'is_anonymous' => true,
                'opens_at' => now(),
                'closes_at' => now()->addMonths(3),
            ]
        );

        $questions = [
            ['question_type' => 'rating', 'prompt' => '¿Cómo calificas tu experiencia académica en este periodo?', 'sort_order' => 1],
            ['question_type' => 'rating', 'prompt' => '¿Qué tan satisfecho estás con el acompañamiento docente?', 'sort_order' => 2],
            ['question_type' => 'text', 'prompt' => '¿Qué mejorarías de tu experiencia universitaria?', 'sort_order' => 3],
        ];

        foreach ($questions as $question) {
            SurveyQuestion::updateOrCreate(
                ['survey_id' => $survey->id, 'sort_order' => $question['sort_order']],
                $question + ['is_required' => $question['question_type'] !== 'text']
            );
        }
    }
}
