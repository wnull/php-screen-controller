<?php

/**
 * Class ScreenController
 *
 * Package management utility <screen> (Linux/GNU).
 * Start, kill, and process list.
 */
class ScreenController
{
    /**
     * @var array $keys
     */
    private $keys = ['pid', 'name', 'date'];

    /**
     * ScreenController constructor.
     */
    public function __construct()
    {
        shell_exec('dpkg -l | grep screen') or die('The <screen> package is not installed' . PHP_EOL);
    }

    /**
     * Starts the process by name and passed parameters
     *
     * @param string $name
     * @param array $params
     * @return bool
     */
    public function start(string $name, array $params = []): bool
    {
        $list = $this->list();

        foreach ($list as $process) {
            if ($process['name'] === $name) {
                throw new \RuntimeException('A process with this name already exists');
            } else {
                shell_exec(sprintf('screen -dmS %s php %s', $name, join(' ', $params)));
                break;
            }
        }

        $list = $this->list();

        foreach ($list as $process) {
            if ($process['name'] === $name) {
                return true;
            }
        }

        return false;
    }

    /**
     * Kills the process by <name> or <pid>
     *
     * @param string $by
     * @param $process
     * @return bool
     */
    public function kill(string $by, $process): bool
    {
        $exec = false;

        switch ($by)
        {
            case 'pid':
                $exec = sprintf('kill %d', (int) $process);
                break;

            case 'name':
                $exec = sprintf('screen -XS %s quit', (string) $process);
                break;
        }

        $allProcess = $this->list();

        foreach ($allProcess as $itemProcess)
        {
            if ($itemProcess[$by] === $process) {
                shell_exec($exec);
                return true;
            }
        }

        return false;
    }

    /**
     * Returns a list of processes
     *
     * @return array
     */
    public function list(): array
    {
        $list = shell_exec('screen -ls');

        preg_match_all('/(\d+)\.([^\h]+)\h*\(([^\)]+)/', $list, $matchesList, PREG_SET_ORDER);

        return array_map(function ($item) {
            unset($item[0]);
            return array_combine($this->keys, $item);
        }, $matchesList);
    }
}