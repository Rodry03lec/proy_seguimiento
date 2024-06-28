<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Configuracion\Ambito;
use App\Models\Configuracion\Grado_academico;
use App\Models\Configuracion\Profesion;
    
class Seeder_profesiones extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ambito = array(
            [
                'nombre'=>'Ámbito de la Salud',
                'descripcion'=>'Se dedica a mantener, mejorar y restaurar la salud de las personas y comunidades.'
            ],
            [
                'nombre'=>'Ámbito Legal',
                'descripcion'=>'El ámbito legal abarca todas las leyes y reglas que gobiernan el comportamiento en una sociedad. Involucra profesionales como abogados y jueces, y se ocupa de resolver conflictos y proteger derechos, manteniendo el orden y la justicia.'
            ],
            [
                'nombre'=>'Ámbito de la Tecnología',
                'descripcion'=>'El ámbito de la tecnología se ocupa de crear, aplicar y mejorar herramientas tecnológicas. Incluye áreas como informática e inteligencia artificial, buscando soluciones y mejoras en diversos aspectos de la sociedad. En resumen, se centra en la evolución y aplicación de la tecnología para resolver problemas y aumentar la eficiencia.'
            ],
            [
                'nombre'=>'Ámbito Empresarial',
                'descripcion'=>'El ámbito empresarial abarca las actividades y decisiones de las empresas para lograr sus metas económicas de manera eficiente. Incluye aspectos como la competencia, estrategias y gestión de recursos. En resumen, se trata del entorno en el que las empresas operan para crecer y tener éxito.'
            ],
            [
                'nombre'=>'Ámbito Educativo',
                'descripcion'=>'El ámbito educativo abarca todo lo relacionado con la enseñanza y el aprendizaje, desde la labor de los profesores hasta la creación de programas y entornos para el desarrollo de los estudiantes. En resumen, se trata del ámbito dedicado a facilitar el conocimiento y habilidades en un contexto formativo.'
            ],
            [
                'nombre'=>'Ámbito Creativo y Artes',
                'descripcion'=>'Involucra profesionales que expresan creatividad a través de diversas formas artísticas, como arte visual, diseño gráfico, música, literatura, teatro y fotografía.'
            ],
            [
                'nombre'=>'Ámbito Ambiental',
                'descripcion'=>'Se ocupa de la conservación y gestión sostenible del medio ambiente. Incluye roles en biología ambiental, ingeniería ambiental y gestión de recursos naturales.'
            ],
            [
                'nombre'=>'Ámbito Social y Servicios Comunitarios',
                'descripcion'=>'Se enfoca en el bienestar social y comunitario, abordando problemas sociales y ofreciendo servicios a individuos y comunidades necesitadas.'
            ],
        );
        foreach ($ambito as $lis) {
            $ambito_guardar = new Ambito();
            $ambito_guardar->nombre = $lis['nombre'];
            $ambito_guardar->descripcion = $lis['descripcion'];
            $ambito_guardar->save();
        }



        //para el llenado de las profesiones
        $profesiones = array(
            [
                'nombre'=>'Medicina',
                'id_ambito'=>'1'
            ],
            [
                'nombre'=>'Enfermería',
                'id_ambito'=>'1'
            ],
            [
                'nombre'=>'Farmacia',
                'id_ambito'=>'1'
            ],
            [
                'nombre'=>'Fisioterapia',
                'id_ambito'=>'1'
            ],
            [
                'nombre'=>'Psicología',
                'id_ambito'=>'1'
            ],
            [
                'nombre'=>'Nutrición',
                'id_ambito'=>'1'
            ],
            [
                'nombre'=>'Odontología',
                'id_ambito'=>'1'
            ],
            [
                'nombre'=>'Biomedicina',
                'id_ambito'=>'1'
            ],
            [
                'nombre'=>'Bioquímica',
                'id_ambito'=>'1'
            ],
            [
                'nombre'=>'Abogado',
                'id_ambito'=>'2'
            ],
            [
                'nombre'=>'Notario',
                'id_ambito'=>'2'
            ],
            [
                'nombre'=>'Ciencias Jurídicas',
                'id_ambito'=>'2'
            ],
            [
                'nombre'=>'Criminología',
                'id_ambito'=>'2'
            ],
            [
                'nombre'=>'Administración de Justicia',
                'id_ambito'=>'2'
            ],
            [
                'nombre'=>'Asesor(a) Legal',
                'id_ambito'=>'2'
            ],
            [
                'nombre'=>'Informática',
                'id_ambito'=>'3'
            ],
            [
                'nombre'=>'Ciencia de Datos',
                'id_ambito'=>'3'
            ],
            [
                'nombre'=>'Ingenieria de sistemas',
                'id_ambito'=>'3'
            ],
            [
                'nombre'=>'Desarrollo de Software',
                'id_ambito'=>'3'
            ],
            [
                'nombre'=>'Ingeniería de Redes',
                'id_ambito'=>'3'
            ],
            [
                'nombre'=>'Seguridad Informática',
                'id_ambito'=>'3'
            ],
            [
                'nombre'=>'Diseño UX/UI',
                'id_ambito'=>'3'
            ],
            [
                'nombre'=>'Administración de Sistemas',
                'id_ambito'=>'3'
            ],
            [
                'nombre'=>'Ingeniería de Hardware',
                'id_ambito'=>'3'
            ],
            [
                'nombre'=>'Administración de Empresas',
                'id_ambito'=>'4'
            ],
            [
                'nombre'=>'Contabilidad',
                'id_ambito'=>'4'
            ],
            [
                'nombre'=>'Marketing',
                'id_ambito'=>'4'
            ],
            [
                'nombre'=>'Finanzas',
                'id_ambito'=>'4'
            ],
            [
                'nombre'=>'Gestión de Proyectos',
                'id_ambito'=>'4'
            ],
            [
                'nombre'=>'Educación Primaria',
                'id_ambito'=>'5'
            ],
            [
                'nombre'=>'Educación Secundaria',
                'id_ambito'=>'5'
            ],
            [
                'nombre'=>'Pedagogía',
                'id_ambito'=>'5'
            ],
            [
                'nombre'=>'Psicopedagogía',
                'id_ambito'=>'5'
            ],
            [
                'nombre'=>'Educación Especial',
                'id_ambito'=>'5'
            ],
            [
                'nombre'=>'Educación Física',
                'id_ambito'=>'5'
            ],
            [
                'nombre'=>'Administración Educativa',
                'id_ambito'=>'5'
            ],
            [
                'nombre'=>'Ciencias de la Educación',
                'id_ambito'=>'5'
            ],
            [
                'nombre'=>'Diseño Gráfico',
                'id_ambito'=>'6'
            ],
            [
                'nombre'=>'Música',
                'id_ambito'=>'6'
            ],
            [
                'nombre'=>'Arquitectura',
                'id_ambito'=>'6'
            ],
            [
                'nombre'=>'Ingeniería Ambiental',
                'id_ambito'=>'7'
            ],
            [
                'nombre'=>'Energías Renovables',
                'id_ambito'=>'7'
            ],
            [
                'nombre'=>'Ciencias Forestales',
                'id_ambito'=>'7'
            ],
            [
                'nombre'=>'Trabajo Social',
                'id_ambito'=>'8'
            ],
            [
                'nombre'=>'Psicología Social',
                'id_ambito'=>'8'
            ],
            [
                'nombre'=>'Sociología',
                'id_ambito'=>'8'
            ],
        );
        
        foreach ($profesiones as $lis) {
            $profesiones = new Profesion();
            $profesiones->nombre = $lis['nombre'];
            $profesiones->estado = 'activo';
            $profesiones->id_ambito = $lis['id_ambito'];
            $profesiones->save();
        }

        //ahora llenaremos los grados profesionales
        $grados = array(
            [
                'abreviatura'   => 'Lic.',
                'nombre'        => 'Licenciatura'
            ],
            [
                'abreviatura'   => 'Abg.',
                'nombre'        => 'Abogado'
            ],
            [
                'abreviatura'   => 'Ing.',
                'nombre'        => 'Ingeniero'
            ],
            [
                'abreviatura'   => 'Tec.',
                'nombre'        => 'Técnico Medio'
            ],
            [
                'abreviatura'   => 'Sr.',
                'nombre'        => 'Señor'
            ],
            [
                'abreviatura'   => 'Sra.',
                'nombre'        => 'Señora'
            ],
            [
                'abreviatura'   => 'Srta.',
                'nombre'        => 'Señorita'
            ],
            [
                'abreviatura'   => 'Univ.',
                'nombre'        => 'Universitario'
            ],
            [
                'abreviatura'   => 'Tec. Sup.',
                'nombre'        => 'Tecnico Superior'
            ],
            [
                'abreviatura'   => 'Arq.',
                'nombre'        => 'Arquitecto'
            ],
            [
                'abreviatura'   => 'Sec.',
                'nombre'        => 'Secretaria'
            ],
        );
        foreach ($grados as $lis) {
            $guardar_grados                 = new Grado_academico();
            $guardar_grados->abreviatura    = $lis['abreviatura'];
            $guardar_grados->nombre         = $lis['nombre'];
            $guardar_grados->estado         = 'activo';
            $guardar_grados->save();
        }
    }
}
