<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Http\JsonResponse;

use App\Logic\Service\TreeService;

use App\Logic\Repository\TreeRepository;

class TreeController extends Controller
{
    /**
     * @var TreeService
     */
    private $treeService;

    /**
     * @var TreeRepository
     */
    private $treeRepository;

    /**
     * TreeController constructor.
     *
     * @param TreeRepository $treeRepository
     *
     * @param TreeService $treeService
     */
    public function __construct(TreeRepository $treeRepository, TreeService $treeService)
    {
        $this->treeService = $treeService;
        $this->treeRepository = $treeRepository;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function getTreeView()
    {
        return view('trees.index');
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $tree = $this->treeRepository->createTree();

        return response()->json($tree);
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $node = $this->treeService->treeToArray($this->treeRepository->findNode($id));

        return response($node);
    }

    /**
     * @param int $id
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        $node = $this->treeRepository->findNode($id);

        $node->update($this->treeService->update($request));

        return response($this->treeService->treeToArray($node));
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $parentNode = $this->treeRepository->findNode($request->parentId);

        $lastChildTree = $this->treeRepository->getLastChildTree($parentNode->id);

        $node = $this->treeRepository->create($this->treeService->create($parentNode, $lastChildTree));

        return response($this->treeService->treeToArray($node));
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function updateTreePosition(Request $request)
    {
        $node = $this->treeRepository->findNode($request->targetNodeId);

        $destinationNode = $this->treeRepository->findNode($request->destinationNodeId);

        $status = $request->status;

        if ($status == 'drag-above')
        {
            $position = $destinationNode->position;

            $parentId = $destinationNode->parent_id;
        } elseif ($status == 'drag-below')
        {
            $position = $destinationNode->position + 1;

            $parentId = $destinationNode->parent_id;
        } elseif ($status == 'drag-on')
        {
            $lastChildTree = $this->treeRepository->getLastChildTree($destinationNode->id);

            $position = $lastChildTree ? $lastChildTree->position + 1 : 1;

            $parentId = $destinationNode->id;
        }

        $this->treeRepository->incrementPosition($parentId, $position);

        $this->treeRepository->update($node, $this->treeService->updatePosition($position, $parentId));

        return response($this->treeService->toArray($node));
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->treeRepository->destroy($id);

        return response([
            'status' => 'success'
        ]);
    }
}
