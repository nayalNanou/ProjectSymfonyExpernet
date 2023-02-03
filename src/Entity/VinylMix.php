<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\VinylMixRepository;

#[ORM\Entity(repositoryClass: VinylMixRepository::class)]
#[ORM\Table(name: 'vinyl_mix')]
class VinylMix
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(name: 'title', type: 'string', length: 255, nullable: false)]
    private ?string $title = null;

    #[ORM\Column(name: 'description', type: 'text', nullable: true)]
    private ?string $description = null;

    #[ORM\Column(name: 'track_count', type: 'integer')]
    private ?int $trackCount = null;

    #[ORM\Column(name: 'created_at', type: 'datetime_immutable')]
    private ?\DateTimeImmutable $createdAt;

    #[ORM\Column(name: 'genre', type: 'string', length: 255, nullable: true)]
    private ?string $genre = null;

    #[ORM\Column(name: 'votes', type: 'integer')]
    private ?int $votes = 0;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getTrackCount(): ?int
    {
        return $this->trackCount;
    }

    public function setTrackCount(?int $trackCount): self
    {
        $this->trackCount = $trackCount;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(?string $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getVotes(): ?int
    {
        return $this->votes;
    }

    public function setVotes(?int $votes): self
    {
        $this->votes = $votes;

        return $this;
    }

    public function getVotesString(): string
    {
        if ($this->votes > 0) {
            return sprintf('+%d', $this->votes);
        } else if ($this->votes < 0) {
            return sprintf('%d', $this->votes);
        } else {
            return '0';
        }
    }

    public function getImageUrl(int $width): string
    {
        return sprintf('https://picsum.photos/id/%d/%d', ($this->getId() + 50) % 1000, $width);
    }
}