<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\Menu;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $admin = $this->createUser("Admin", ["ROLE_ADMIN"], "password");
        $manager->persist($admin);
        $author = $this->createUser("Author", ["ROLE_AUTHOR"], "password");
        $manager->persist($author);
        $user = $this->createUser("User", ["ROLE_USER"], "password");
        $manager->persist($user);

        $category1 = $this->createCategory("Tutoriel c#", "tutoriel-c-sharp", "#720ac7");
        $manager->persist($category1);
        $category2 = $this->createCategory("Tutoriel Symfony", "tutoriel-symfony", "#1df500");
        $manager->persist($category2);

        $article1 = $this->createArticle("Créer un blog", "creer-un-blog", "<div><strong>Voici le contenu<br></strong><strong><del>Voici le contenu</del></strong><del> <br></del><em>Voici le contenu&nbsp;</em></div>", "Ceci est un article", $category1);
        $manager->persist($article1);
        $article2 = $this->createArticle("Un article sur symfony", "un-article-sur-symfony", "<div>test</div>", "un article sur symfony", $category2);
        $manager->persist($article2);

        $comment1 = $this->createComment("super", $article1, $admin);
        $manager->persist($comment1);
        $comment2 = $this->createComment("Intéressant", $article1, $user);
        $manager->persist($comment2);
        $comment3 = $this->createComment("surprenant", $article2, $author);
        $manager->persist($comment3);

        $menu1 = $this->createMenu($article1, $category1, "Tutoriel C#", 1);
        $manager->persist($menu1);
        $menu2 = $this->createMenu($article2, $category2, "Mes articles", 2);
        $manager->persist($menu2);

        $manager->flush();
    }

    public function createUser(string $username, array $role, string $password)
    {
        $user = new User();
        $user->setUsername($username);
        $user->setRoles($role);
        $user->setPassword(
            $this->hasher->hashPassword(
                $user,
                $password
            )
        );

        return $user;
    }

    public function createCategory(string $name, string $slug, string $color)
    {
        $category = new Category();
        $category->setName($name);
        $category->setSlug($slug);
        $category->setColor($color);

        return $category;
    }

    public function createArticle(string $title, string $slug, string $content, string $featText, Category $category)
    {
        $article = new Article();
        $article->setTitle($title);
        $article->setSlug($slug);
        $article->setContent($content);
        $article->setFeaturedText($featText);
        $article->addCategory($category);
        $article->setCreatedAt(new \DateTime());

        return $article;
    }

    public function createComment(string $content, Article $article, User $user)
    {
        $comment = new Comment($article);
        $comment->setContent($content);
        $comment->setUser($user);
        $comment->setCreatedAt(new \DateTime());

        return $comment;
    }

    public function createMenu(Article $article, Category $category, string $name, int $order)
    {
        $menu = new Menu();
        $menu->setArticle($article);
        $menu->setCategory($category);
        $menu->setName($name);
        $menu->setMenuOrder($order);
        $menu->setIsVisible(true);
        $menu->setLink("#");

        return $menu;
    }

}
