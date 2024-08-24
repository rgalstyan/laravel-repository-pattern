<?php
namespace App\Services;
use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Illuminate\Database\Eloquent\Model;

abstract class CRUDService
{
    protected string $path = '';

    public function get( array $data = [], $debug = false ): mixed
    {
        if ( empty( $data['orders'] ) ) {
            $data['orders'] = [];
        }

        if ( empty( $data['conditions'] ) ) {
            $data['conditions'] = [];
        }

        if ( ! array_key_exists( 'all', $data ) ) {
            $data['all'] = true;
        }

        $model = $this->model->where( $data['conditions'] );

        foreach ( $data['orders'] as $field => $order ) {
            $model = $model->orderBy( $field, $order );
        }

        if(!empty($data['paginate'])){
            $model = $model->paginate($data['paginate']);
        }
        elseif(!empty($data['simplePaginate'])){
            $model = $model->simplePaginate($data['simplePaginate']);
        }
        if(!empty($data['paginate']) || !empty($data['simplePaginate'])){
            return $model;
        }
        if(!empty($data['select'])){
            $model = $model->select($data['select']);
        }

        if ( $debug ) {
            return $model->toSql();
        }

        if(!empty($data['offset'])){
            $model = $model->skip($data['offset']);
        }
        if(!empty($data['limit'])){
            $model = $model->take($data['limit']);
        }

        if ( $data['all'] ) {
            return $model->get();
        }

        return $model->first();
    }

    public function delete( array $conditions ): bool
    {
        return $this->model->where( $conditions )->delete();
    }

    public function update( array $conditions, array $data ): Model
    {
        return $this->model->where( $conditions )->update( $data );
    }

    public function create( array $data ): Model
    {
        return $this->model->create( $data );
    }

    public function updateOrCreateWithFile( array $data ): Model
    {
        $files = [];
        foreach($data['fields'] as $key => $field)
        {
            if ($field instanceof UploadedFile) {
                $file = FileService::upload( $field, [
                    'path' => $this->path,
                    'cropParams' => !empty($data['cropParams'])?$data['cropParams']:[],
                    'fitParams' => !empty($data['fitParams'])?$data['fitParams']:[]
                ] );
                $files[] = $file['uniqueName'];
                $data['fields'][$key] = $file['uniqueName'];
            }
        }

        if ( empty( $data['id'] ) ) {
            $model = $this->create( $data['fields'] );
        } else {
            $model = $this->get( [ 'conditions' => [ 'id' => $data['id'] ], 'all' => false ] );
            if(!empty($data['fields'][$data['fileFieldName']]))
            {
                FileService::delete( public_path( $this->path ) . '/' . $model->{($data['fileFieldName'])} );
            }
            $model->update( $data['fields'] );
        }
        if ( ! $model ) {
            if($files)
            {
                foreach($files as $new_file)
                {
                    FileService::delete( public_path( $this->path ) . '/' . $new_file );
                }
            }
            throw new \Exception( 'Something went wrong. Can not create or update.' );
        }

        return $model;
    }

    public function updateOrCreate( array $conditions, array $data ): Model
    {
        $model = $this->model->where( $conditions );
        if($model->first()) {
            $model->update( $data );
            $model = $model->first();
        }
        else {
            $model = $this->model->create( $data );
        }
        return $model;
    }

    public function getFillable(): array
    {
        return $this->model->getFillable();
    }

    public function in( array $data, bool $getModel = false ): Model | Collection
    {
        $model = $this->model;
        foreach ( $data as $field => $values ) {
            $model = $model->whereIn( $field, $values );
        }
        return $getModel ? $model : $model->get();
    }

    public function getModel(): Model
    {
        return $this->model;
    }

    public function insert( array $data ): Model
    {
        return $this->model->insert( $data );
    }
}