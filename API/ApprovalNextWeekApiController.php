<?php

/*
 * This file is part of the Kimai time-tracking app.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiPlugin\ApprovalBundle\API;

use App\Repository\UserRepository;
use Exception;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandlerInterface;
use KimaiPlugin\ApprovalBundle\Repository\ApprovalRepository;
use Swagger\Annotations as SWG;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @SWG\Tag(name="ApprovalNextWeekApi")
 */
final class ApprovalNextWeekApiController extends AbstractController
{
    public function __construct(private readonly ViewHandlerInterface $viewHandler, private readonly UserRepository $userRepository, private readonly ApprovalRepository $approvalRepository, private readonly AuthorizationCheckerInterface $security, private readonly TranslatorInterface $translator)
    {
    }

    /**
     * @SWG\Response(
     *     response=200,
     *     description="Status of selected week"
     * )
     *
     * @SWG\Parameter(
     *      name="user",
     *      in="query",
     *      type="integer",
     *      description="User ID to get information for",
     *      required=false,
     * )
     *
     * @Rest\Get(path="/next-week")
     * @ApiSecurity(name="apiUser")
     * @ApiSecurity(name="apiToken")
     * @throws Exception
     */
    public function nextWeek(Request $request): Response
    {
        $selectedUserId = $request->query->get('user', -1);
        $currentUser = $this->userRepository->find($this->getUser()->getId());

        if ($selectedUserId !== -1) {
            if (!$this->isGrantedViewAllApproval() && !$this->isGrantedViewTeamApproval()) {
                return $this->error400($this->translator->trans('api.accessDenied'));
            }
            if (
                !$this->isGrantedViewAllApproval() &&
                $this->isGrantedViewTeamApproval() &&
                empty($this->checkIfUserInTeam($currentUser, $selectedUserId))
            ) {
                return $this->error400($this->translator->trans('api.wrongTeam'));
            }
            $selectedUser = $this->userRepository->find($selectedUserId);
            if (!$selectedUser || !$selectedUser->isEnabled()) {
                return $this->error404($this->translator->trans('api.wrongUser'));
            }
            $currentUser = $selectedUser;
        }

        $nextApproveWeek = $this->approvalRepository->getNextApproveWeek($currentUser);
        if ($nextApproveWeek) {
            return $this->viewHandler->handle(
                new View(
                    $this->translator->trans(
                        $nextApproveWeek
                    ),
                    200
                )
            );
        }

        return $this->error404($this->translator->trans('api.noData'));
    }

    private function isGrantedViewAllApproval(): bool
    {
        return $this->security->isGranted('view_all_approval');
    }

    private function isGrantedViewTeamApproval(): bool
    {
        return $this->security->isGranted('view_team_approval');
    }

    protected function error404(string $message): Response
    {
        return $this->viewHandler->handle(
            new View($message, 404)
        );
    }

    protected function error400(string $message): Response
    {
        return $this->viewHandler->handle(
            new View($message, 400)
        );
    }

    protected function checkIfUserInTeam($user, $selectedUserId): array
    {
        return array_filter(
            $user->getTeams(),
            function ($team) use ($selectedUserId) {
                foreach ($team->getUsers() as $user) {
                    if ($user->getId() == $selectedUserId) {
                        return true;
                    }
                }

                return false;
            }
        );
    }
}
