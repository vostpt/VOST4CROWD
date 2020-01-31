<?php
declare(strict_types=1);

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $rally2020Data = [
            'title'       => 'Ocorrências no Rally de Portugal 2020',
            'description' => 'Ocorrências no Rally de Portugal 2020',
            'icon'        => null,
            'fields'      => [],
        ];

        $rally2020Data['fields'][] = [
            'label'    => 'Tipo de Ocorrência',
            'name'     => 'ocurrence_type',
            'nullable' => false,
            'type'     => 'single_choice',
            'icon'     => null,
        ];

        $rally2020Data['fields'][] = [
            'label'    => 'Foto',
            'name'     => 'picture',
            'nullable' => true,
            'type'     => 'picture',
            'icon'     => null,
        ];

        Project::create($rally2020Data);

        //factory(Project::class,5)->create();
    }
}
