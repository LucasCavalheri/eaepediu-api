<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;

class CategoryPolicy
{
    /**
     * Determine whether the user can view any categories.
     */
    public function viewAny(User $user): bool
    {
        // Qualquer usuário autenticado pode listar suas categorias
        return true;
    }

    /**
     * Determine whether the user can view the category.
     */
    public function view(User $user, Category $category): bool
    {
        // Apenas o dono do restaurante associado pode visualizar a categoria
        return $user->id === $category->restaurant->user_id;
    }

    /**
     * Determine whether the user can create a category.
     */
    public function create(User $user, int $restaurantId): bool
    {
        // Verifica se o usuário é o dono do restaurante onde deseja criar a categoria
        $restaurant = $user->restaurants()->find($restaurantId);

        return $restaurant !== null;
    }

    /**
     * Determine whether the user can update the category.
     */
    public function update(User $user, Category $category): bool
    {
        // Apenas o dono do restaurante associado pode atualizar a categoria
        return $user->id === $category->restaurant->user_id;
    }

    /**
     * Determine whether the user can delete the category.
     */
    public function delete(User $user, Category $category): bool
    {
        // Apenas o dono do restaurante associado pode deletar a categoria
        return $user->id === $category->restaurant->user_id;
    }
}
